<?php
/**
 * Description of ttggestor
 *
 * @author juanantonio
 */

include_once dirname(__FILE__).'/ttggamer.php';
include_once dirname(__FILE__).'/ttgcamp.php';
include_once dirname(__FILE__).'/ttgtournament.php';
include_once dirname(__FILE__).'/ttgrace.php';
include_once dirname(__FILE__).'/ttgevent.php';
include_once dirname(__FILE__).'/ttgeventgamer.php';
include_once dirname(__FILE__).'/ttgranking.php';

class ttgGestor {

    /**     *
     * @var int[] $racesids
     */
    private $racesids = array();
    /** 
     * @var int[] $campsids
     */
    private $campsids = array();
    /** 
     * @var int[] $tournamentsids
     */    
    private $tournamentsids = array();
    /** 
     * @var int[] $eventsids
     */    
    private $eventsids = array();
    /** 
     * @var array $racetable
     */
    private $racetable;
    /** 
     * @var array $camptable
     */
    private $camptable;
    /** 
     * @var array $tournamenttable
     */
    private $tournamenttable;
    /** 
     * @var int[] $eventtable
     */
    private $eventtable;
    /** 
     * @var ttgRace[] $races
     */
    private $races;
    /** 
     * @var ttgCamp[] $camps
     */
    private $camps;
    /** 
     * @var ttgTournament[] $tournaments
     */
    private $tournaments;
    /** 
     * @var ttgEvent[] $events
     */
    private $events;
    /** 
     * @var int $id_camp
     */
    public $id_camp;


    public function __construct() {
        $this->init();
        $this->setCampsIds();
        $this->setRacesIds();
        $this->setTournamentsIds();
        $this->setEventsIds();
    }
    
    public function init(){
        global $wpdb;
        $this->racetable = $wpdb->prefix . 'ttg_races';
        $this->camptable = $wpdb->prefix . 'ttg_camps';
        $this->tournamenttable = $wpdb->prefix . 'ttg_tournaments';
        $this->eventtable = $wpdb->prefix . 'ttg_events';
        $this->rankingtable = $wpdb->prefix . 'ttg_rankings';
    }
    /**
     * 
     * @return int[]
     */
    public function getRacesIds() {
        return $this->racesids;
    }
    /**
     * 
     * @return int[]
     */
    public function getCampsIds() {
        return $this->campsids;
    }
    /**
     * 
     * @return int[]
     */
    public function getEventsIds() {
        return $this->eventsids;
    }
    /**
     * 
     * @return int[]
     */    
    public function getTournamentsIds() {
        return $this->tournamentsids;
    }
    /**
    * 
    * @return ttgRace[]
    */
    public function getRaces(){
        if(empty($this->races)){
            $this->setRaces();
        }
        return $this->races;
    }
    /**
    * 
    * @return ttgRace
    */    
    public function getRace($id_race){
        if(empty($this->races)){
            $this->setRaces();
        }
        if(isset($this->races[$id_race])){
            return $this->races[$id_race];
        }
        return FALSE;
    }
    /**
     * 
     * @return ttgCamp[]
     */
    public function getCamps(){
        if(empty($this->camps)){
            $this->setCamps();
        }
        return $this->camps;
    }

    /**
     * 
     * @return ttgCamp
     */
    public function getCamp($id_camp){
        if(empty($this->camps)){
            $this->setCamps();
        }
        if(isset($this->camps[$id_camp])){
            return $this->camps[$id_camp];
        }
        return FALSE;
    }    
    /**
     * 
     * @return ttgTournament[]
     */    
    public function getTournaments(){
        if(empty($this->tournaments)){
            $this->setTournaments();
        }
        return $this->tournaments;
    }
    /**
     * 
     * @return ttgTournament
     */ 
    public function getTournament($id_tournament){
        if(empty($this->tournaments)){
            $this->setTournaments();
        }
        if(isset($this->tournaments[$id_tournament])){
            return $this->tournaments[$id_tournament];
        }
        return FALSE;
    }
    /**
     * 
     * @return ttgEvent[]
     */     
    public function getEvents(){
        if(empty($this->events)){
            $this->setEvents();
        }
        return $this->events;
    }
    /**
     * 
     * @return ttgEvent
     */     
    public function getEvent($id_event){
        if(empty($this->events)){
            $this->setEvents();
        }
        if(isset($this->events[$id_event])){
            return $this->events[$id_event];
        }
        return FALSE;
    }
    /**
     * 
     * @return ttgEvent
     */  
    public function getEventbyIdProdut($id_product=0){
        global $wpdb;
        $event = $wpdb->get_row( "SELECT * FROM {$this->eventtable} WHERE id_post_product=".$id_product );
        if(!empty($event)){
            return new ttgEvent($event->id);
        }
        return null;
    }
    /**
     * 
     * @return ttgRanking
     */      
    public function getRankingbyIdRankingPost($id_product=0){
        global $wpdb;
        $ranking = $wpdb->get_row( "SELECT * FROM {$this->rankingtable} WHERE id_post_ranking=".$id_product );
        if(!empty($ranking)){
            return new ttgRanking($ranking->id);
        }
        return null;
    }

    public function insertUpdateBBDDCard($data){
        $camp = new ttgCamp($this->id_camp);
        return $camp->insertUpdateBBDDCard($data);
    }

    public function deleteCard($data){
        $camp = new ttgCamp($this->id_camp);
        return $camp->deleteCard($data);
    }
    
    public function insertUpdateBBDDResult($data){
        $event = new ttgEvent();
        $user = new ttgGamer();
    }
    
    private function setRacesIds() {
        global $wpdb;
        $field_name = 'id';
        $this->racesids = $wpdb->get_col( "SELECT {$field_name} FROM {$this->racetable}" );
    }
    
    private function setCampsIds() {
        global $wpdb;
        $field_name = 'id';
        $this->campsids = $wpdb->get_col( "SELECT {$field_name} FROM {$this->camptable}" );
    }
    
    private function setTournamentsIds() {
        global $wpdb;
        $field_name = 'id';
        $this->tournamentsids = $wpdb->get_col( "SELECT {$field_name} FROM {$this->tournamenttable}" );
    }
    
    private function setEventsIds() {
        global $wpdb;
        $field_name = 'id';
        $this->eventsids = $wpdb->get_col( "SELECT {$field_name} FROM {$this->eventtable}" );
    }
    
    private function setRaces(){
        foreach ($this->racesids as $raceid) {
            $this->races[$raceid]= new ttgRace($raceid);
        }
    }
    private function setCamps(){
        foreach ($this->campsids as $campid) {
            $this->camps[$campid]= new ttgCamp($campid);
        }
        return $this->camps;
    }
    
    private function setTournaments(){
        foreach ($this->tournamentsids as $tournamentid) {
            $this->tournaments[$tournamentid]= new ttgTournament($tournamentid);
        }
    }
    
    private function setEvents(){
        foreach ($this->eventsids as $eventsid) {
            $this->events[$eventsid]= new ttgEvent($eventsid);
        }
    }
    
    private function compareIdProdut($array){
        if($array->getIdProduct()==$this->currentidproduct){
            $this->currentevent=$array;
        }
    }
    
}
