<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Description of shortcodes
 *
 * @author juanantonio
 */
class ttgShortcodes {
    /**
     * @var ttgGestor $ttggestor
     */
    private $ttggestor;
    
    /**
     * 
     * @param ttgGestor $ttggestor
     */
    public function __construct($ttggestor) {
        $this->ttggestor=$ttggestor;
        $this->init();
    }
    
    public function init() {
        add_shortcode('getevent',array( $this, 'getEvent' ));
        add_shortcode('ttggeteventfilter',array( $this, 'ttgGetEventFilter' ));
    }
    
    public function getEvent($id_product) {
        $event=$this->ttggestor->getEventbyIdProdut($id_product['id']);
        $result=array();
        if($event!=null){
            $result = array(
                'id_camp' => $event->getIdCamp(),
                'id_tournament' => $event->getIdTournament(),
                'id_race' => $event->getIdRace(),
                'date' => strtotime($event->getDate()),
                'time' => $event->getTime()
            );
        }
        return serialize($result);
    }
    
    public function ttgGetEventFilter($productsids) {
        $productsids=unserialize($productsids['productsids']);
        $camps = array();
        $states = array();
        $tournaments = array();
        foreach ($productsids as $productsid) {
            $event=$this->ttggestor->getEventbyIdProdut($productsid);
            $camps[$event->getCamp()->getIdCamp()] = $event->getCamp()->getName();
            $states[$event->getCamp()->getIdState()] = $event->getCamp()->getState();
            $tournaments[$event->getTournament()->getIdTournament()] = $event->getTournament()->getName();
        }
        uasort($camps, 'ttgHelper::orderAsc');
        uasort($states, 'ttgHelper::orderAsc');
        uasort($tournaments, 'ttgHelper::orderAsc');
        $result=array('camps'=>$camps, 'states'=>$states, 'tournaments'=>$tournaments);
        return serialize($result);
    }
}