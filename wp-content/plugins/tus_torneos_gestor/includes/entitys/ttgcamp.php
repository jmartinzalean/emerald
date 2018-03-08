<?php
/**
 * Entidad base Camp
 *
 * @author juanantonio
 */
class ttgCamp {
    
    private $id_camp;
    private $camp;
    private $name;
    private $address;
    private $cp;
    private $id_town;
    private $id_state;
    private $card;
    private $holes;
    private $state;
    private $town;
    private $phone;


    public function __construct($id_camp=0) {
        $this->id_camp = $id_camp;
        if($id_camp!=0){
            $this->setInfoCamp();    
        }
    }
    
    public function getIdCamp () {
        return $this->id_camp;
    }
    
    public function getCamp () {
        return $this->camp;
    }
    
    public function getName () {
        return $this->name;
    }
    
    public function getAddress () {
        return $this->address;
    }
    
    public function getCp () {
        return $this->cp;
    }
    
    public function getIdTown () {
        return $this->id_town;
    }
    
    public function getIdState () {
        return $this->id_state;
    }

    public function getState () {
        if(empty($this->state)){
            $this->setState();
        }
        return $this->state;
    }

    public function getTown () {
        if(empty($this->town)){
            $this->setTown();
        }
        return $this->town;
    }

    public function getPhone () {
        return $this->phone;
    }
    
    public function getCard () {
        if(empty($this->card)){
            $this->setCard();
        }
        return $this->card;
    }
    public function getHoles () {
        if(empty($this->holes)){
            $this->setHoles();
        }
        return $this->holes;
    }
    /**
     * 
     * @param array $data
     */
    public function insertUpdateBBDDCamp(array $data){
        global $wpdb;
        $wpdb->replace($wpdb->prefix."ttg_camps",$data);
        if($this->id_camp==0){
            $this->id_camp = $wpdb->insert_id;
            $this->setInfoCamp();
        }
    } 

    public function insertUpdateBBDDCard(array $data){
        global $wpdb;
        $wpdb->replace($wpdb->prefix."ttg_cards",$data);
        if(!isset($this->id_card) || $this->id_card==0){
            $this->id_card = $wpdb->insert_id;
            $this->setCard();
        }
        return true;
    }

    public function deleteCard(array $data){
        global $wpdb;
        $wpdb->delete($wpdb->prefix."ttg_cards", $data);
        return true;
    }

    private function setInfoCamp () {
        if(empty($this->camp)){
            $this->setBBDDCamp();
        }
        if( !empty($this->camp)){
            $this->name = $this->camp->name;
            $this->address = $this->camp->address;
            $this->cp = $this->camp->cp;
            $this->id_town = $this->camp->id_town;
            $this->id_state = $this->camp->id_state;
            $this->phone = $this->camp->phone;
        }
    }
    
    private function setHoles () {
        if(empty($this->card)){
            $this->setCard();
        }
        if(empty($this->holes)){
            $this->createHoles();
        }
        return $this->holes;
    }
    
    private function createHoles() {
        foreach ($this->card as $card) {
            $this->card_id = $card->id;
            $this->holes[$card->id] = new stdClass();
            $this->holes[$card->id]->id_card = $card->id;
            $this->holes[$card->id]->par = $card->par;
            $this->holes[$card->id]->handicap = $card->handicap_hole;
        }
    }

    private function setBBDDCamp () {
        global $wpdb;
        $this->camp= $wpdb->get_row( "SELECT * FROM ".$wpdb->prefix."ttg_camps g WHERE g.id=".$this->id_camp );
    }
    
    private function setCard () {
        global $wpdb;
        $this->card= $wpdb->get_results( "SELECT * FROM wp_ttg_cards g WHERE g.id_camp=".$this->id_camp." order by hole ASC" );
    }
    
    private function setState () {
        global $wpdb;
        $state= $wpdb->get_row( "SELECT name FROM wp_ttg_states g WHERE g.id=".$this->id_state );
        if($state){
           $this->state=$state->name;
        }
    }
    
    private function setTown () {
        global $wpdb;
        $town= $wpdb->get_row( "SELECT name FROM wp_ttg_towns g WHERE g.id_state=".$this->id_town );
        if($town){
           $this->town=$town->name;
        }
    }
    
}
