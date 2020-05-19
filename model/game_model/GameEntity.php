<?php

class GameEntity {
    
    private $game_id;
    private $date_time;
    private $is_won_by_player;
    private $rounds_num;
    private $nickname_id;

    public function __construct($game_id = null, $date_time = null, 
        $is_won_by_player = null, $rounds_num = null, $nickname_id = null) {

        $this->game_id = $game_id;
        $this->date_time = $date_time;
        $this->is_won_by_player = $is_won_by_player;
        $this->rounds_num = $rounds_num;
        $this->nickname_id = $nickname_id;
    }

    function getGameId() {
        return $this->game_id;
    }

    function setGameId($game_id) {
        $this->game_id = $game_id;
    }

    function getDateTime() {
        return $this->date_time;
    }

    function setDateTime($date_time) {
        $this->date_time = $date_time;
    }

    function getIsWonByPlayer() {
        return $this->is_won_by_player;
    }

    function setIsWonByPlayer($is_won_by_player) {
        $this->is_won_by_player = $is_won_by_player;
    }

    function getRoundsNum() {
        return $this->rounds_num;
    }

    function setRoundsNum($rounds_num) {
        $this->rounds_num = $rounds_num;
    }

    function getNicknameId() {
        return $this->nickname_id;
    }

    function setNicknameId($nickname_id) {
        $this->nickname_id = $nickname_id;
    }

}

?>