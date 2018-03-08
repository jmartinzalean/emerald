<?php
/**
 * Description of customfields
 *
 * @author juanantonio
 */

class ttgCustomFields {
    
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
        add_action( 'init', array($this, 'ttgRegisterMetaFields') );
        add_action( 'add_meta_boxes_product', array($this, 'ttgMetaBoxes') );
        add_action( 'save_post',  array($this, 'ttgSaveEventField'), 10, 2 );
    }

    public function ttgRegisterMetaFields() {
          register_meta( 'product',
                        'ttg_race',
                        array (
                          'description'      => 'Elija un circuito...',
                          'single'           => true,
                           'sanitize_callback' => array($this, 'ttgSanitizeSelectField'),
                           'auth_callback'     => array($this,'ttgCustomFieldsAuthCallback')
                        )
            );

            register_meta( 'product',
                         'ttg_tournament',
                        array (
                           'description'      => 'Elija un torneo...',
                           'single'           => true,
                           'sanitize_callback' => array($this, 'ttgSanitizeSelectField'),
                           'auth_callback'     => array($this,'ttgCustomFieldsAuthCallback')
                         )
            );

            register_meta( 'product',
                         'ttg_camp',
                        array (
                           'description'      => 'Elija un campo...',
                           'single'           => true,
                           'sanitize_callback' => array($this, 'ttgSanitizeSelectField'),
                           'auth_callback'     => array($this,'ttgCustomFieldsAuthCallback')
                         )
            );
            register_meta( 'product',
                         'ttg_date',
                        array (
                           'description'      => 'Fecha',
                           'single'           => true,
                           'sanitize_callback' => array($this, 'ttgSanitizeSelectField'),
                           'auth_callback'     => array($this,'ttgCustomFieldsAuthCallback')
                         )
            );
            register_meta( 'product',
                         'ttg_hour',
                        array (
                           'description'      => 'Hora',
                           'single'           => true,
                           'sanitize_callback' => array($this, 'ttgSanitizeSelectField'),
                           'auth_callback'     => array($this,'ttgCustomFieldsAuthCallback')
                         )
            );
    }

    public function ttgSanitizeSelectField( $value ) {
        
        if( ! empty( $value ) && $value!=0 ) {
            return 1;
        } else {
            return 0;
        }

    }
    
    public function ttgCustomFieldsAuthCallback( $allowed, $meta_key, $post_id, $user_id, $cap, $caps ) {
  
        if( 'post' == get_post_type( $post_id ) && current_user_can( 'edit_post', $post_id ) ) {
            $allowed = true;
        } else {
            $allowed = false;
        }
        return $allowed;

    }
    public function ttgMetaBoxes() {
        add_meta_box(
                'ttg-meta-box',
                 'Indique los datos del evento',
                 array($this, 'ttgMetaBoxCallback'),
                 'product',
                 'advanced',
                 'core'
        );
    }


    public function ttgMetaBoxCallback( $post ) {
        
        $event= $this->ttggestor->getEventbyIdProdut($post->ID);
        if($event){
            $camp=$event->getIdCamp();
            $race=$event->getIdRace();
            $tournament=$event->getIdTournament();
            $date=$event->getDate();
            $time=$event->getTime();
        }else{
            $camp=0;
            $race=0;
            $tournament=0;
            $date= date('Y-m-d');
            $time= date('H:i:s');
        }
        $options= $this->getOptionsCamp();
        $this->ttgPrepareField('camp','Campo',$options,$camp);
        $options= $this->getOptionsRace();
        $this->ttgPrepareField('race','Circuito',$options,$race);
        $options= $this->getOptionsTournament();
        $this->ttgPrepareField('tournament','Torneo',$options,$tournament);
        $this->ttgDatePickerField(array('date'=>$date,'time'=>$time));
    }
    

    public function ttgSaveEventField( $post_id, $post ){
        $data=array();
        if(isset($_REQUEST['ttg-field-race'])&&isset($_REQUEST['ttg-field-camp'])&&isset($_REQUEST['ttg-field-tournament'])){
            $data['id_race']=$_REQUEST['ttg-field-race'];
            $data['id_camp']=$_REQUEST['ttg-field-camp'];
            $data['id_tournament']=$_REQUEST['ttg-field-tournament'];
            $data['date']=$_REQUEST['ttg-field-date'];
            $data['time']=$_REQUEST['ttg-field-time'];            
            $data['id_post_product']=$post_id;
            $event=$this->ttggestor->getEventbyIdProdut($post_id);
            if($event){
                $data['id']=$event->getIdEvent();
                $event->insertUpdateBBDDEvent($data);
            }else{
                $event=new ttgEvent();
                $event->insertUpdateBBDDEvent($data);
            }
        }
    }
    
    private function ttgDatePickerField($date){
        $tpl = new ttgViewBase(TTG_PLUGIN_TEMPLATES.'ttg-field-date-template.php');
        $tpl->setVars($date);
        echo $tpl->parse();
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
    
    private function getOptionsCamp(){        
        $options = array();
        $camps = $this->ttggestor->getCamps();
        foreach ($camps as $camp) {
            $options[$camp->getIdCamp()] = ucfirst($camp->getName());
        }
        return $options;
    }
    
    private function getOptionsRace(){        
        $options = array();
        $races = $this->ttggestor->getRaces();
        foreach ($races as $race) {
            $options[$race->getIdRace()] = ucfirst($race->getName());
        }
        return $options;
    }
    
    private function getOptionsTournament(){        
        $options = array();
        $tournaments = $this->ttggestor->getTournaments();
        foreach ($tournaments as $tournament) {
            $options[$tournament->getIdTournament()] = ucfirst($tournament->getName());
        }
        return $options;
    }
    
}
