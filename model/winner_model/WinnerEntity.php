<?php

class WinnerEntity {
    
    private $winner_id;
    private $winner;
    private $games_won_num;

    public function __construct($winner_id = null, $winner = null, $games_won_num = null) {
                            
        $this->winner_id = $winner_id;
        $this->winner = $winner;
        $this->games_won_num = $games_won_num; 
    }

    function getWinnerId(){
        return $this->winner_id;
    }

    function setWinnerId($winner_id){
        $this->winner_id = $winner_id;
    }

    function getWinner(){
        return $this->winner;
    }

    function setWinner($winner){
        return $this->winner = $winner;
    }

    function getGamesWonNum() {
        return $this->games_won_num;
    }

    function setGamesWonNum($games_won_num) {
        $this->games_won_num = $games_won_num;
    }

}

?>