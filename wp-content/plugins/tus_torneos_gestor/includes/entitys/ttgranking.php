<?php

/**
 * Entidad base Ranking
 *
 * @author raul
 */
class ttgRanking {

    private $ranking;
    private $id_ranking;
    private $race;
    private $post_ranking;
    private $id_race;
    private $id_post_ranking;
    
    public function __construct($id_ranking=0) {
        $this->id_ranking = $id_ranking;
        if($id_ranking!=0){
            $this->setInfoRanking();    
        }
    }
    
    public function getRanking() {
        return $this->ranking;
    }
    public function getIdRanking() {
        return $this->id_ranking;
    }
    public function getIdRace() {
        return $this->id_race;
    }
    public function getIdProduct() {
        return $this->id_post_ranking;
    }     
    public function getCamp() {
        if(empty($this->camp)){
            $this->setCamp();
        }
        return $this->camp;
    }
    public function getRace() {
        if(empty($this->race)){
            $this->setRace();
        }
        return $this->race;
    }
    public function getProduct() {
        if(empty($this->post_ranking)){
            $this->setProduct();
        }
        return $this->post_ranking;
    }    
    
    public function insertUpdateBBDDRanking(array $data){
        global $wpdb;
        $wpdb->replace($wpdb->prefix."ttg_rankings",$data);
        if($this->id_camp==0){
            $this->id_camp = $wpdb->insert_id;
            $this->setInfoRanking();
        }
    } 
    
    private function setRace() {
        $this->race = new ttgRace($this->id_race);
    }    

    private function setProduct () {
        $this->post_ranking = get_post( $this->id_post_ranking );
    }
    
    private function setBBDDRanking () {
        global $wpdb;
        $this->ranking= $wpdb->get_row( "SELECT * FROM wp_ttg_rankings g WHERE g.id=".$this->id_ranking );   
    }
    
    private function setInfoRanking () {
        if(empty($this->ranking)){
            $this->setBBDDRanking();
        }
        if( !empty($this->ranking)){
            $this->id_race = $this->ranking->id_race;
            $this->id_post_ranking = $this->ranking->id_post_ranking;
        }
    }
}
