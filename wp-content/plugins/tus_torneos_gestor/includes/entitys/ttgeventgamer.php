<?php

/**
 * Entidad base Event_Gamer
 *
 * @author juanantonio
 */
class ttgEventGamer {

    private $event;
    private $gamer;
    private $result;
    private $strikes;
    private $order;
    private $event_gamer;    
    private $id_event;
    private $id_gamer;
    private $id_result;
    private $id_order;


    public function __construct($event, $gamer) {
        if (is_object($event) && is_object($gamer)) {
            $this->event = $event;
            $this->gamer = $gamer;
            /*if(!empty($this->event->getIdEvent()) && !empty($this->gamer->getIdUser())){
                $this->setInfoEventGamer();    
            }*/
        }
    }
    
    public function getIdEvent() {
        return $this->id_event;
    }
    
    public function getIdGamer() {
        return $this->id_gamer;
    }

    public function getIdResult() {
        return $this->id_result;
    }

    public function getIdOrder() {
        return $this->id_order;
    }    

    public function getEvent() {
        return $this->event;
    }
    public function getGamer() {
        return $this->gamer;
    }
    public function getResult() {
        if (empty($this->result)) {
            $this->setResult();
        }
        return $this->result;
    }
    public function getStrikes() {
        if (empty($this->strikes)) {
            $this->setStrikes();
        }
        return $this->strikes;
    }

    public function getOrder() {
        if(empty($this->order)) {
            $this->setOrder();
        }
        return $this->order;
    }

    private function setResult() {
        if (empty($this->result)) {
            $this->setBBDDResult();
        }
    }
    private function setStrikes () {
        $results = $this->getResult();
        $this->strikes = array(
            '1'=>$results->hole_1,'2'=>$results->hole_2,'3'=>$results->hole_3,
            '4'=>$results->hole_4,'5'=>$results->hole_5,'6'=>$results->hole_6,
            '7'=>$results->hole_7,'8'=>$results->hole_8,'9'=>$results->hole_9,
            '10'=>$results->hole_10,'11'=>$results->hole_11,'12'=>$results->hole_12,
            '13'=>$results->hole_13,'14'=>$results->hole_14,'15'=>$results->hole_15,
            '16'=>$results->hole_16,'17'=>$results->hole_17,'18'=>$results->hole_18        
        );
        
    }
    private function setOrder () {
        $this->order = wc_get_order_id_by_order_item_id($this->id_order);
    }

    private function setBBDDResult () {
        global $wpdb;
        $this->result= $wpdb->get_row( "SELECT * FROM wp_ttg_results g WHERE g.id=".$this->id_result );   
    }
    private function setBBDDEventGamer () {
        global $wpdb;
        $this->event_gamer= $wpdb->get_row( "SELECT * FROM wp_ttg_events_gamers_results "
                . "g WHERE g.id_event=".$this->event->getIdEvent()." AND g.id_gamer=".$this->gamer->getIdGamer() );   
    }
    
    private function setInfoEventGamer () {
        if(empty($this->event_gamer)){
            $this->setBBDDEventGamer();
        }
        if( !empty($this->event_gamer)){
            $this->id_event = $this->event_gamer->id_event;
            $this->id_gamer = $this->event_gamer->id_gamer;
            $this->id_result = $this->event_gamer->id_result;
            $this->id_order = $this->event_gamer->id_order_item;
        }
    }
}
