<?php
/**
 * Entidad base Gamers
 *
 * @author juanantonio
 */
class ttgGamer {
    
    private $user;
    private $id_user;
    private $id_gamer;
    private $name;
    private $surname;
    private $license;
    private $gamer;
    private $handicap;


    public function __construct($id_user=0) {
        $this->id_user = $id_user;
        if($id_user!=0){
            $this->user = get_user_by('id', $id_user);
            $this->setInfoCore();   
        }
    }
    
    public function getFullName () {
        return $this->name.' '.$this->surname;
    }
    
    public function getUser () {
        return $this->user;
    }
    
    public function getIdUser(){
        return $this->id_user;
    }
    
    public function getLicense () {
        if(empty($this->gamer)){
            $this->setInfoGamer();
        }
        return $this->license;
    }
    
    public function getGamer () {
        if(empty($this->gamer)){
            $this->setInfoGamer();
        }
        return $this->gamer;
    }
    
    public function getHandicap () {
        if(empty($this->gamer)){
            $this->setInfoGamer();
        }
        return $this->handicap;
    }
    
    public function getIdGamer () {
        if(empty($this->gamer)){
            $this->setInfoGamer();
        }
        return $this->id_gamer;
    }

    private function setInfoCore() {
        $this->name = $this->user->first_name;
        $this->surname = $this->user->last_name;
    }
    
    private function setInfoGamer () {
        if(empty($this->gamer)){
            $this->setBBDD();
        }
        if( !empty($this->gamer)){
            $this->license = $this->gamer->license;
            $this->handicap = $this->gamer->handicap;
            $this->id_gamer = $this->gamer->id;
        }
    }
    
    private function setBBDD () {
        global $wpdb;
        $this->gamer= $wpdb->get_row( "SELECT * FROM wp_ttg_gamers g WHERE g.id_user=".$this->id_user );
    }
    
    
    
}
