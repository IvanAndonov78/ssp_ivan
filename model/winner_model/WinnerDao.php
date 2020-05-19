<?php 

require_once './model/db.php';
require_once 'WinnerEntity.php';

class WinnerDao extends Db {

    public function __construct(){
        Db::__construct(); //== parent::__construct();
    }

    function getAllWinners() {
        
        $dbconn = $this->conn;
        $sql = "SELECT * FROM t_winner WHERE winner <> 'Computer' ORDER BY games_won_num DESC LIMIT 5";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $rows = array();

        while ($row = $stmt->fetch()) {

            $winner_id = $row['winner_id'];
            $winner = $row['winner'];
            $games_won_num = $row['games_won_num'];

            $rs_winner = new WinnerEntity();
            
            $rs_winner->setWinnerId($winner_id);
            $rs_winner->setWinner($winner);
            $rs_winner->setGamesWonNum($games_won_num);

            $rows[] = array(
                'winner_id' => $rs_winner->getWinnerId(),
                'winner' => $rs_winner->getWinner(),
                'games_won_num' => $rs_winner->getGamesWonNum()
            );
        }

        return $rows;
    }
    
    function insertWinner($winner, $games_won_num) {

        $dbconn = $this->conn;

        $sql = "INSERT INTO t_winner (winner_id, winner, games_won_num) ";
        $sql .= "VALUES (NULL, :winner, :games_won_num)";
        $stmt = $dbconn->prepare($sql);

        $stmt->bindParam(':winner', $winner);
        $stmt->bindParam(':games_won_num', $games_won_num);
        $stmt->execute();
    }

    function getWinnerIdByName($winner) {
        
        if($this->isWinnerExits($winner)) {
            $dbconn = $this->conn;
            $sql = "SELECT winner_id FROM t_winner WHERE winner LIKE " ."'%". $winner . "%'";
            $stmt = $dbconn->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $rows[0]['winner_id']; 

        }
    }

    function updateWinnersDataById($winner, $games_won_num) {
        
        $dbconn = $this->conn;

        $winner_id = $this->getWinnerIdByName($winner);

        $data = [
            'winner_id' => $winner_id,
            'games_won_num' => $games_won_num
        ];

        $sql = "UPDATE t_winner SET games_won_num=:games_won_num WHERE winner_id=:winner_id";

        $stmt = $dbconn->prepare($sql);
        // $stmt->debugDumpParams();
        $stmt->execute($data);
    }

    function score($winner, $games_won_num) {

        $is_registered = $this->isWinnerExits($winner);

        if (!$is_registered) {
            $this->insertWinner($winner, $games_won_num);
        } else {
            $this->updateWinnersDataById($winner, $games_won_num);
        }
    }

    function isWinnerExits($winner) {

        $dbconn = $this->conn;

        $sql = "SELECT winner from t_winner where winner LIKE ". "'%" . $winner . "%'";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(empty($rows)) {
            return false;
        } else {
            return true;
        }

    }


}


?>