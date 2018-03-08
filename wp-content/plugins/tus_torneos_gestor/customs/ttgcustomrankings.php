<?php
/**
 * Description of customrankings
 *
 * @author raul
 */

class ttgCustomRankings {
    
    private $ttggestor;

    /**
     * Construct
     * @param ttgGestor $gestorttg
     */
    public function __construct(ttgGestor $gestorttg) {
        $this->ttggestor = $gestorttg;
        $this->init();
    }
    
    public function init() {
        add_action( 'init', array($this, 'ttgRegisterPostTypeRankings') );      
        add_action( 'init', array($this, 'ttgRegisterRankingsMetaFields') );
        add_action( 'add_meta_boxes_ranking', array($this, 'ttgRankingsMetaBoxes') );
        add_action( 'save_post',  array($this, 'ttgSaveRankingsEventField'), 10, 3 );
        add_action( 'admin_footer-post-new.php', array($this,'ttgRankingsValidator') );
        add_action( 'admin_footer-post.php', array($this,'ttgRankingsValidator') );
        add_filter('single_template', array($this,'ttgRankingsCustomTemplate'));
        
        add_filter('init', array($this,'general_endpoint_init'));
        add_filter('loop_start', array($this,'general_endpoint_loop_start'));

        //add_filter('post_row_actions', array($this,'remove_row_actions'), 10, 1);
    }
    /**
     * Añadir 'general' endpoint
     */
    public function general_endpoint_init(){
        add_rewrite_endpoint( 'general', EP_ALL );
    }
    /**
     * Control endpoint
     */
    public function general_endpoint_loop_start(){
        if ( !is_main_query() ) {
            return;
        }
        $general = get_query_var( 'general' );
        if ( !empty( $general ) ) {
            // show post information if on a permalink
            if ( $general == 'post' ){
                $post = get_post();
                d( $post );
            }
            // show wp_query info if general has value of "query"
            if ( $general == 'query' ) {
                global $wp_query;
                d( $wp_query );
            }
        }
    }

    public function ttgRegisterPostTypeRankings() {
            //POST TYPE Ranking
            $labels = array(
                'name' => _x('Rankings', 'post type general name'),
                'singular_name' => _x('Ranking', 'post type singular name'),
                'add_new' => _x('Añadir nuevo', 'book'),
                'add_new_item' => __('Añadir nuevo Ranking'),
                'edit_item' => __('Editar Ranking'),
                'new_item' => __('Nuevo Ranking'),
                'view_item' => __('Ver Ranking'),
                'search_items' => __('Buscar Rankings'),
                'not_found' =>  __('No se han encontrado rankings'),
                'not_found_in_trash' => __('No se han encontrado rankings en la papelera'), 
                'parent_item_colon' => ''
                );
            $args = array(
                'show_in_menu' => false,
                'labels' => $labels,
                'public' => true,
                'rewrite' => array('slug' => 'rankings'),
                'capability_type' => 'post',
                'has_archive' => true,
                'supports' => array('title', 'thumbnail', 'editor'),
                'menu_icon' => 'dashicons-list-view'
                );
            register_post_type( 'ranking', $args );
            flush_rewrite_rules( false );
    }

    public function ttgRegisterRankingsMetaFields() {

        register_meta( 'ranking',
                      'ttg_race',
                      array (
                        'description'      => 'Elija un circuito...',
                        'single'           => true,
                         'sanitize_callback' => array($this, 'ttgSanitizeRankingsSelectField'),
                         'auth_callback'     => array($this,'ttgRankingsCustomFieldsAuthCallback')
                      )
          );
    }

    public function ttgSanitizeRankingsSelectField( $value ) {
        
        if( ! empty( $value ) && $value!=0 ) {
            return 1;
        } else {
            return 0;
        }

    }
    
    public function ttgRankingsCustomFieldsAuthCallback( $allowed, $meta_key, $post_id, $user_id, $cap, $caps ) {
  
        if( 'post' == get_post_type( $post_id ) && current_user_can( 'edit_post', $post_id ) ) {
            $allowed = true;
        } else {
            $allowed = false;
        }
        return $allowed;

    }
    public function ttgRankingsMetaBoxes() {
        add_meta_box(
                'ttg-meta-box',
                 'Indique los datos del evento',
                 array($this, 'ttgRankingsMetaBoxCallback'),
                 'ranking',
                 'advanced',
                 'core'
        );
    }


    public function ttgRankingsMetaBoxCallback( $post ) {
        
        $ranking= $this->ttggestor->getRankingbyIdRankingPost($post->ID);
        if($ranking){
            $race=$ranking->getIdRace();
        }else{
            $camp=0;
            $race=0;
            $tournament=0;
        }
        $options= $this->getOptionsRace();
        $this->ttgPrepareField('race','Circuito',$options,$race);

    }

    public function ttgRankingsValidator(){
        if ( 'ranking' !== $GLOBALS['post_type'] ){
            return;
        }
        ?>
        <style>
            .advise{text-align:center;position:relative;}
            .advise1:after{
                content: "\A";
                border-style: solid;
                border-width: 10px 15px 10px 0;
                border-color: transparent #ccc transparent transparent;
                transform: rotate(-90deg);
                margin: 0 0 -5px 10px;
                display: inline-block;
            }
            .advise2:after{
                content: "\A";
                border-style: solid;
                border-width: 10px 15px 10px 0;
                border-color: transparent #ccc transparent transparent;
                transform: rotate(90deg);
                margin: 0 0 -3px 10px;
                display: inline-block;
            }
        </style>
        <script>
        (function() {
            <?php
                //currently edited post id 
                $cep_id = $_GET['post'];
            ?>
            var permalink = '<?php echo get_permalink( $cep_id );?>';
            if(permalink.indexOf('general')<0){
                jQuery('#postdivrich').hide();
            }

            jQuery('#sbg-sortables').hide();
            jQuery('#titlewrap').hide();
            jQuery('input#title').prop('disabled', true);
        })();
        document.getElementById("ttg-field-race").onchange = changeRankingTitle;
        function changeRankingTitle() {
            jQuery('label#title-prompt-text').text('');
            jQuery('input#title').val('');
            var race = jQuery('select#ttg-field-race').val();
            if(race!=0){
                race = jQuery('select#ttg-field-race option:selected').text();
            }else{
                race = '';
            }
            jQuery('input#title').val(race);
        };
        document.getElementById("publish").onclick = function() {
            jQuery('#error_rankings').remove();
            var status = true;
            var message = '';
            var title = jQuery('input#title').val();
            var race = jQuery('select#ttg-field-race').val();
            /*if(title==''){
                message+='<p>Indique un título</p>';
                status = false;
            }*/
            if(race==0){
                message+='<p>Seleccione un Circuito</p>';
                status = false;
            }

            if(!status){
                jQuery('#wpbody-content .wrap').prepend('<div id="error_rankings" class="error">'+message+'</div>');
                return false;
            }else{
                jQuery('input#title').prop('disabled', false);
                return;
            }

        };</script>
        <?php
    }

    public function ttgRankingsCustomTemplate($single) {

        global $wp_query, $post;
    
        /* Checks for single template by post type */
        if ( $post->post_type == 'ranking' ) {
            if ( file_exists( plugin_dir_path( __DIR__ ) . 'templates/rankings-template.php' ) ) {
                return plugin_dir_path( __DIR__ ). 'templates/rankings-template.php';
            }
        }
        
                /* Checks for single template by post type */
        if ( $post->post_type == 'ranking_page' ) {
            if ( file_exists( plugin_dir_path( __DIR__ ) . 'templates/rankings-general-template.php' ) ) {
                return plugin_dir_path( __DIR__ ). 'templates/rankings-general-template.php';
            }
        }
    
        return $single;
    
    }
    

    public function ttgSaveRankingsEventField( $post_id, $post ){
        $data=array();

        if(isset($_REQUEST['ttg-field-race'])){
            $data['id_post_ranking']=$post_id;
            $data['id_race']=$_REQUEST['ttg-field-race'];
            $ranking=$this->ttggestor->getRankingbyIdRankingPost($post_id);
            if($ranking){
                $data['id']=$ranking->getIdRanking();
                $ranking->insertUpdateBBDDRanking($data);
            }else{
                $ranking=new ttgRanking();
                $ranking->insertUpdateBBDDRanking($data);
            }
        }
    }
    
    private function ttgPrepareField($id,$text,$options,$current){
        $field['id'] = 'ttg-field-'.$id;
        $field['text'] = $text;
        $field['options'] = $options;
        $field['current'] = $current;
        $tpl = new ttgViewBase(TTG_PLUGIN_TEMPLATES.'ttg-field-template.php');
        $tpl->setVars($field);
        echo $tpl->parse();
    }
    
    private function getOptionsRace(){        
        $options = array();
        $races = $this->ttggestor->getRaces();
        $options[99999] = 'GENERAL';
        foreach ($races as $race) {
            $options[$race->getIdRace()] = ucfirst($race->getName());
        }
        return $options;
    }

    public function remove_row_actions( $actions ) {
        if( get_post_type() === 'ranking' ){
            unset( $actions['view'] );
        }
    }
    
}