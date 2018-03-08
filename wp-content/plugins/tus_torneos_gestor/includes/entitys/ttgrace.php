<?php
/**
 * Entidad base Race
 *
 * @author juanantonio
 */
class ttgRace {
    
    private $id_race;
    private $name;
    private $state;
    private $race;     
    
    public function __construct($id_race=0) {
        $this->id_race = $id_race;
        if($id_race!=0){
            $this->setInfoRace();    
        }
    }
    
    public function getIdRace () {
        return $this->id_race;
    }

    public function getName () {
        return $this->name;
    }

    public function getState () {
        return $this->state;
    }

    public function getRace () {
        return $this->race;
    }
    
    /**
     * 
     * @param array $data
     */
    public function insertUpdateBBDDRace(array $data){
        global $wpdb;
        $wpdb->replace($wpdb->prefix."ttg_races",$data);
        if($this->id_race==0){
            $this->id_race = $wpdb->insert_id;
            $this->setInfoRace();
        }
    } 
    
    private function setBBDDRace () {
        global $wpdb;
        $this->race= $wpdb->get_row( "SELECT * FROM wp_ttg_races g WHERE g.id=".$this->id_race );        
    }
    
    private function setInfoRace () {
        if(empty($this->race)){
            $this->setBBDDRace();
        }
        if( !empty($this->race)){
            $this->name = $this->race->name;
            $this->state = $this->race->state;
        }
    }    
}
