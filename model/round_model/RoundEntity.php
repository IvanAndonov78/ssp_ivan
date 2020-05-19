<?php

class RoundEntity {
    
    private $rec_id;
    private $game_id;
    private $player_choice;
    private $pc_choice;
    private $player_point;
    private $pc_point;
    private $round_num;
    
    public function __construct($rec_id = null, $game_id = null, 
                        $player_choice = null, $pc_choice = null, 
                        $player_point = null, $pc_point = null, 
                        $round_num = null) {

        $this->rec_id = $rec_id;
        $this->game_id = $game_id;
        $this->player_choice = $player_choice;
        $this->pc_choice = $pc_choice;
        $this->player_point = $player_point;
        $this->pc_point = $pc_point;
        $this->round_num = $round_num;       
    }

    function getRecId() {
        return $this->rec_id;
    }

    function setRecId($rec_id) {
        $this->rec_id = $rec_id;
    }

    function getGameId() {
        return $this->game_id;
    }

    function setGameId($game_id) {
        $this->game_id = $game_id;
    }

    function getPlayerChoice() {
        return $this->player_choice;
    }

    function setPlayerChoice($player_choice) {
        $this->player_choice = $player_choice;
    }

    function getPcChoice() {
        return $this->pc_choice;
    }

    function setPcChoice($pc_choice) {
        $this->pc_choice = $pc_choice;
    }

    function getPlayerPoint() {
        return $this->player_point;
    }

    function setPlayerPoint($player_point) {
        $this->player_point = $player_point;
    }

    function getPcPoint() {
        return $this->pc_point;
    }

    function setPcPoint($pc_point) {
        $this->pc_point = $pc_point;
    }

    function getRoundNum() {
        return $this->round_num;
    }

    function setRoundNum($round_num) {
        $this->round_num = $round_num;
    }

}

?>