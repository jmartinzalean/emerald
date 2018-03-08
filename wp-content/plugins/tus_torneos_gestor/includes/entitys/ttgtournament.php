<?php
/**
 * Entidad base Tournamente
 *
 * @author juanantonio
 */
class ttgTournament {
    
    private $id_tournament;
    private $name;
    private $state;
    private $tournament;     
    
    public function __construct($id_tournament=0) {
        $this->id_tournament = $id_tournament;
        if($id_tournament!=0){
            $this->setInfoTournament();    
        }
    }
    
    public function getIdTournament () {
        return $this->id_tournament;
    }

    public function getName () {
        return $this->name;
    }

    public function getState () {
        return $this->state;
    }

    public function getTournament () {
        return $this->tournament;
    }
       /**
     * 
     * @param array $data
     */
    public function insertUpdateBBDDTournament(array $data){
        global $wpdb;
        $wpdb->replace($wpdb->prefix."ttg_tournaments",$data);
        if($this->id_tournament==0){
            $this->id_tournament = $wpdb->insert_id;
            $this->setInfoTournament();
        }
    } 
    
    private function setBBDDTournament () {
        global $wpdb;
        $this->tournament= $wpdb->get_row( "SELECT * FROM wp_ttg_tournaments g WHERE g.id=".$this->id_tournament );        
    }
    
    private function setInfoTournament () {
        if(empty($this->tournament)){
            $this->setBBDDTournament();
        }
        if( !empty($this->tournament)){
            $this->name = $this->tournament->name;
            $this->state = $this->tournament->state;
        }
    }    
}
