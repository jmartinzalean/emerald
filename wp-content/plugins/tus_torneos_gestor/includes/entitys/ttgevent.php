<?php

/**
 * Entidad base Event
 *
 * @author juanantonio
 */
class ttgEvent {
    /**
     * @var array $event
     */
    private $event;
    /**
     * @var int $id_event
     */    
    private $id_event;
    /**
     * @var ttgCamp $camp
     */
    private $camp;
    /**
     * @var ttgTournament $tournament
     */
    private $tournament;
    /**
     * @var ttgRace $race
     */
    private $race;
    /**
     * @var WP_Post $product
     */
    private $product;    
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var string $date
     */
    private $date;
    /**
     * @var string $time
     */
    private $time;
    /**
     * @var int $id_camp
     */
    private $id_camp;
    /**
     * @var int $id_tournament
     */
    private $id_tournament;
    /**
     * @var int $id_race
     */
    private $id_race;
    /**
     * @var int $id_product
     */
    private $id_product;
    
    public function __construct($id_event=0) {
        $this->id_event = $id_event;
        if($id_event!=0){
            $this->setInfoEvent();    
        }
    }
    /**
     * @return array
     */    
    public function getEvent() {
        return $this->event;
    }
    /**
     * @return int
     */        
    public function getIdEvent() {
        return $this->id_event;
    }
    /**
     * @return string
     */        
    public function getName() {
        return $this->name;
    }
    /**
     * @return string
     */        
    public function getDate() {
        return $this->date;
    }
    /**
     * @return string
     */        
    public function getTime() {
        return $this->time;
    }
    /**
     * @return int
     */        
    public function getIdTournament() {
        return $this->id_tournament;
    }
    /**
     * @return int
     */      
    public function getIdCamp() {
        return $this->id_camp;
    }
    /**
     * @return int
     */      
    public function getIdRace() {
        return $this->id_race;
    }
    /**
     * @return int
     */      
    public function getIdProduct() {
        return $this->id_product;
    }
    /**
     * @return ttgCamp
     */      
    public function getCamp() {
        if(empty($this->camp)){
            $this->setCamp();
        }
        return $this->camp;
    }
    /**
     * @return ttgTournament
     */        
    public function getTournament() {
        if(empty($this->tournament)){
            $this->setTournament();
        }
        return $this->tournament;
    }
    /**
     * @return ttgRace
     */        
    public function getRace() {
        if(empty($this->race)){
            $this->setRace();
        }
        return $this->race;
    }
    /**
     * @return WP_Post
     */     
    public function getProduct() {
        if(empty($this->product)){
            $this->setProduct();
        }
        return $this->product;
    }    
    
    public function insertUpdateBBDDEvent(array $data){
        global $wpdb;
        $wpdb->replace($wpdb->prefix."ttg_events",$data);
        if($this->id_camp==0){
            $this->id_camp = $wpdb->insert_id;
            $this->setInfoEvent();
        }
    } 
    
    private function setRace() {
        $this->race = new ttgRace($this->id_race);
    }    
    private function setTournament() {
        $this->tournament = new ttgTournament($this->id_tournament);
    }
    private function setCamp() {
        $this->camp = new ttgCamp($this->id_camp);
    }

    private function setProduct () {
        $this->product = get_post( $this->id_product );
    }
    
    private function setBBDDEvent () {
        global $wpdb;
        $this->event= $wpdb->get_row( "SELECT * FROM wp_ttg_events g WHERE g.id=".$this->id_event );   
    }
    
    private function setInfoEvent () {
        if(empty($this->event)){
            $this->setBBDDEvent();
        }
        if( !empty($this->event)){
            $this->name = $this->event->name;
            $this->date = $this->event->date;
            $this->time = $this->event->time;
            $this->id_camp = $this->event->id_camp;
            $this->id_tournament = $this->event->id_tournament;
            $this->id_race = $this->event->id_race;
            $this->id_product = $this->event->id_post_product;
        }
    }
}
