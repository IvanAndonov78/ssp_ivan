<?php 

require_once './model/db.php';
require_once 'RoundEntity.php';

class RoundDao extends Db {

    public function __construct(){
        Db::__construct(); //== parent::__construct();
    }

    function getAllRounds() {

        $dbconn = $this->conn;
        $sql = "SELECT * FROM t_round";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        $rows = array();

        while($row = $stmt->fetch()) {

            $rec_id = $row['rec_id'];
            $game_id = $row['game_id'];
            $player_choice = $row['player_choice'];
            $pc_choice = $row['pc_choice'];
            $player_point = $row['player_point'];
            $pc_point = $row['pc_point'];
            $round_num = $row['round_num'];          

            $rs = new RoundEntity();
            $rs->setRecId($rec_id);
            $rs->setGameId($game_id);
            $rs->setPlayerChoice($player_choice);
            $rs->setPcChoice($pc_choice);
            $rs->setPlayerPoint($player_point);
            $rs->setPcPoint($pc_point);
            $rs->setRoundNum($round_num);

            $rows[] = array(
                'rec_id' => $rs->getRecId(),
                'game_id' => $rs->getGameId(),
                'player_choice' => $rs->getPlayerChoice(),
                'pc_choice' => $rs->getPcChoice(),
                'player_point' => $rs->getPlayerPoint(),
                'pc_point' => $rs->getPcPoint(),
                'round_num' => $rs->getRoundNum()
            );
        }

        return $rows;
    }

    function insertRound($game_id, $player_choice, $pc_choice, $player_point, 
                $pc_point, $round_num) {
        
        $dbconn = $this->conn;

        $data = [
            'game_id' => $game_id,
            'player_choice' => $player_choice,
            'pc_choice' => $pc_choice,
            'player_point' => $player_point,
            'pc_point' => $pc_point,
            'round_num' => $round_num
        ];

        $sql = "INSERT INTO t_round (rec_id, game_id, player_choice, pc_choice, ";
        $sql .= "player_point, pc_point, round_num) ";
        $sql .= "VALUES (NULL, :game_id, :player_choice, :pc_choice, :player_point, ";
        $sql .= ":pc_point, :round_num)";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute($data);

        $dbconn = null; 
    }

    function getRoundDataByGameId($game_id) {

        $dbconn = $this->conn;
        $sql = "SELECT * FROM t_round WHERE game_id=" . $game_id;
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    function getLastRoundNumByGameId($game_id) {

        $dbconn = $this->conn;
        $sql = "SELECT round_num FROM t_round  WHERE game_id = 2 ORDER BY round_num DESC LIMIT 1";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($rows)) {
            return $rows[0]['round_num'];
        } else {
            $rows[0]['round_num'] = 0;
            return $rows[0]['round_num'];
        }
    }

}

?>