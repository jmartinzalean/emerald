<?php
/**
 * Description of ttgajax
 *
 * @author juanantonio
 */
class ttgAjax {

    /**
     *
     * @var ttGestor $ttggestor
     */
    private $ttggestor;
    /**
     * Construct
     * @param ttgGestor $gestorttg
     */
    public function __construct(ttgGestor $gestorttg) {
        $this->ttggestor = $gestorttg;
        $this->init();
    }
    
    public function init(){
        add_action( 'rest_api_init', array($this, 'registerRest'));
    }
    
    public function registerRest(){
            register_rest_route( 'wp/v2', '/getcampos/', array(
                'methods' => 'GET',
                'callback' => array($this,'getCamps'),
                        'args' => array(
                                'keyword'  => array( 'required' => true )
                                )
                        )
                    );
            register_rest_route( 'wp/v2', '/getusers/', array(
                'methods' => 'GET',
                'callback' => array($this,'getGamers')
            ));
            register_rest_route( 'wp/v2', '/getgamereventresult/', array(
                'methods' => 'POST',
                'callback' => array($this,'getGamerEventResult')
            ));            
            register_rest_route( 'wp/v2', '/updatecards/', array(
                'methods' => array('POST','GET'),
                'callback' => array($this,'updateCards')
            ));
            register_rest_route( 'wp/v2', '/updateresult/', array(
                'methods' => array('POST'),
                'callback' => array($this,'updateresult')
            ));    
            register_rest_route( 'wp/v2', '/deletecard/', array(
                'methods' => array('POST','GET'),
                'callback' => array($this,'deleteCard')
            ));
    }
    /**
     * TODO llevarlo a ttgestor
     * @global type $wpdb
     * @param WP_REST_Request $request
     */
    public function getCamps(WP_REST_Request $request) {
        $params = $request->get_params();
        global $wpdb; // this is how you get access to the databaseglobal $wpdb;
        $myArr = array();
        $wp_campos_search = $wpdb->get_results("SELECT e.id AS 'id_event', CONCAT(r.`name`,'-',t.`name`,'-',c.`name`) AS 'name' FROM wp_ttg_events e
                LEFT JOIN wp_ttg_camps c ON e.id_camp=c.id
                LEFT JOIN wp_ttg_races r ON e.id_race=r.id
                LEFT JOIN wp_ttg_tournaments t ON e.id_tournament=t.id
                WHERE c.`name` LIKE '%".$params['keyword']."%' OR t.`name` LIKE '%".$params['keyword']."%' OR r.`name` LIKE '%".$params['keyword']."%'
                ORDER BY e.id");

        foreach ( $wp_campos_search as $campo ) {
            $myArr[] = array(
                'id'=>$campo->id_event,
                'name'=>$campo->name
            );
        }
        return new WP_REST_Response( $myArr, 200 );
    }
     /**
     * TODO llevarlo a ttgestor
     * @global type $wpdb
     * @param WP_REST_Request $request
     */
    public function getGamers(WP_REST_Request $request) {
        $params = $request->get_params();
        global $wpdb;
        $myArr = array();
        $wp_user_search = $wpdb->get_results("SELECT u.ID AS 'id', u.user_email AS 'email', u.display_name AS 'name', g.license AS 'license' FROM wp_users u
            LEFT JOIN wp_ttg_gamers g ON g.id_user = u.ID
            where u.display_name like '%".$params["keyword"]."%' or u.user_email like '%".$params["keyword"]."%' OR g.license LIKE '%".$params["keyword"]."%' ORDER BY u.display_name ASC");

        foreach ( $wp_user_search as $userid ) {
            $meta = get_user_meta($userid);
            $myArr[] = array(
                'id'=>$userid->id,
                'name'=>$userid->name,
                'last_name'=>$meta['last_name'][0],
                'email'=>$userid->email,
                'license'=>$userid->license,
                ''
            );
        }
        return new WP_REST_Response($myArr, 200 );
    }
    
    public function getGamerEventResult(WP_REST_Request $request) {
        $params = $request->get_params();
        global $wpdb;
        $myArr = array('msn'=>FALSE);
        $wp_search = $wpdb->get_row("SELECT egr.id as 'id_egr', egr.handicap_game AS 'handicap', g.license AS 'license',
            egr.id_result AS 'id_result', r.hole_1 AS 'hole_1', r.hole_2 AS 'hole_2', r.hole_3 AS 'hole_3', r.hole_4 AS 'hole_4', r.hole_5 AS 'hole_5', 
            r.hole_6 AS 'hole_6', r.hole_7 AS 'hole_7', r.hole_8 AS 'hole_8', r.hole_9 AS 'hole_9', r.hole_10 AS 'hole_10', r.hole_11 AS 'hole_11', 
            r.hole_12 AS 'hole_12', r.hole_13 AS 'hole_13', r.hole_14 AS 'hole_14',r.hole_15 AS 'hole_15', r.hole_16 AS 'hole_16', r.hole_17 AS 'hole_17', 
            r.hole_18 AS 'hole_18' FROM wp_ttg_events_gamers_results egr
            LEFT JOIN wp_ttg_events e ON egr.id_event = e.id
            LEFT JOIN wp_ttg_gamers g ON egr.id_gamer = g.id
            LEFT JOIN wp_ttg_results r ON egr.id_result = r.id
            WHERE egr.id_event = ".$params['id_event']." AND g.id_user = ".$params['id_user']);
        if($wp_search){
            $categories = $wpdb->get_results("SELECT c.id AS 'id_category' FROM wp_ttg_events_gamers_results_category egrc
                LEFT JOIN wp_ttg_category c ON egrc.id_category =  c.id
                WHERE egrc.id_event_gamers_result = ".$wp_search->id_egr);
        }
        if($wp_search){
            $myArr = array(
                'msn'=>TRUE,
                'id_egr'=>$wp_search->id_egr,
                'handicap'=>$wp_search->handicap,
                'license'=>$wp_search->license,
                'categories'=> array(),
                'id_result'=>$wp_search->id_result,
                'holes'=>array(
                    'hole_1'=>$wp_search->hole_1,
                    'hole_2'=>$wp_search->hole_2,
                    'hole_3'=>$wp_search->hole_3,
                    'hole_4'=>$wp_search->hole_4,
                    'hole_5'=>$wp_search->hole_5,
                    'hole_6'=>$wp_search->hole_6,
                    'hole_7'=>$wp_search->hole_7,
                    'hole_8'=>$wp_search->hole_8,
                    'hole_9'=>$wp_search->hole_9,
                    'hole_10'=>$wp_search->hole_10,
                    'hole_11'=>$wp_search->hole_11,
                    'hole_12'=>$wp_search->hole_12,
                    'hole_13'=>$wp_search->hole_13,
                    'hole_14'=>$wp_search->hole_14,
                    'hole_15'=>$wp_search->hole_15,                    
                    'hole_16'=>$wp_search->hole_16,
                    'hole_17'=>$wp_search->hole_17,
                    'hole_18'=>$wp_search->hole_18                    
                )               
            );
            if($categories){
                foreach ($categories as $category) {
                    $myArr['categories'][]=$category->id_category;
                }
            }
        }
        return new WP_REST_Response($myArr, 200 );
    }

    public function updateCards(WP_REST_Request $request) {
        $params = $request->get_params();
        $this->ttggestor->id_camp = $params['id_camp'];
        foreach($params['cards'] as $card){
            $myArr = array(
                'status'=>$this->ttggestor->insertUpdateBBDDCard($card)
            );
        }
        return new WP_REST_Response($myArr, 200 );
    }

    public function deleteCard(WP_REST_Request $request) {
        $params = $request->get_params();
        $this->ttggestor->id_camp = $params['id_camp'];
        foreach($params['cards'] as $card){
            $myArr = array(
                'status'=>$this->ttggestor->deleteCard($card)
            );
        }
        return new WP_REST_Response($myArr, 200 );
    }
    public function updateresult(WP_REST_Request $request) {
        $params = $request->get_params();
        /*gamer*/
        $gamerdata=array();
        global $wpdb;
        $gamer= $wpdb->get_row( "SELECT id FROM wp_ttg_gamers g WHERE g.id_user=".$params['user'] );
        if(empty($gamer)){
            $gamerdata['id']=0;
        }else{
            $gamerdata['id']=$gamer->id;
        }
        $gamerdata['id_user']=$params['user'];
        $gamerdata['license']=$params['license'];
        $wpdb->replace($wpdb->prefix."ttg_gamers",$gamerdata);
        if($gamerdata['id']==0){
            $gamerdata['id']=$wpdb->insert_id;
        }
         //var_dump($gamerdata);
        /*gamer*/
        /*result*/
        $resultdata=array();
        $resultdata=$params['holes'];
        if(empty($params['result'])){
            $resultdata['id']=0;
        }else{
            $resultdata['id']=$params['result'];
        }
        $wpdb->replace($wpdb->prefix."ttg_results",$resultdata);
        if($resultdata['id']==0){
            $resultdata['id']=$wpdb->insert_id;
        }
                 //var_dump($resultdata);
        /*result*/
        /*egr*/
        $egrdata=array();
        if(empty($params['egr'])){
            $egrdata['id']=0;          
        }else{
            $egrdata['id']=$params['egr'];
        }
        $egrdata['id_event']=$params['camp'];
        $egrdata['id_gamer']=$gamerdata['id'];
        $egrdata['id_result']=$resultdata['id'];
        $egrdata['handicap_game']=$params['handicap'];
        $wpdb->replace($wpdb->prefix."ttg_events_gamers_results",$egrdata);  
        if($egrdata['id']==0){
            $egrdata['id']=$wpdb->insert_id;
        }
        /*egr*/
        
        $wpdb->delete( $wpdb->prefix."ttg_events_gamers_results_category", array( 'id_event_gamers_result' => $egrdata['id'] ) );
        
        foreach($params['category'] as $category){
            $wpdb->replace($wpdb->prefix."ttg_events_gamers_results_category",array( 'id_event_gamers_result' => $egrdata['id'], 'id_category' => $category ));
        }
        
        if($gamerdata['id']>0 && $resultdata['id']>0 && $egrdata['id']>0){
            $myArr = array(
                'msn'=>TRUE,
                'codigo'=>'Registro guardado correctamente'
                );
        }else{
            $myArr = array(
                'msn'=>FALSE,
                'codigo'=>'No se ha podido guardar el registro. Contacte con el adminsitrador del sistema'
                );
        }
        return new WP_REST_Response($myArr, 200 );
    }
}

