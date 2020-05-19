<?php 

require_once './model/db.php';
require_once 'GameEntity.php';

class GameDao extends Db {

    public function __construct(){
        Db::__construct(); //== parent::__construct();
    }

    function getAllGames() {
        
        $dbconn = $this->conn;
        $sql = "SELECT * FROM t_game";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        // $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); the lazy way, but not better! :)

        $rows = array();

        while ($row = $stmt->fetch()) {

            $game_id = $row['game_id'];
            $date_time = $row['date_time'];
            $is_won_by_player = $row['is_won_by_player'];
            $rounds_num = $row['rounds_num'];
            $nickname_id = $row['nickname_id'];

            $rs = new GameEntity();
            $rs->setGameId($game_id);
            $rs->setDateTime($date_time);
            $rs->setIsWonByPlayer($is_won_by_player);
            $rs->setRoundsNum($rounds_num);
            $rs->setNicknameId($nickname_id);

            $rows[] = array(
                'game_id' => $rs->getGameId(),
                'date_time' => $rs->getDateTime(),
                'is_won_by_player' => $rs->getIsWonByPlayer(),
                'rounds_num' => $rs->getRoundsNum(),
                'nickname_id' => $rs->getNicknameId()
            );
        }

        return $rows;
    }
    
    function insertGame($rounds_num, $nickname_id) {

        $dbconn = $this->conn;
        
        $date_time = date("Y-m-d H:i:s");
        $is_won_by_player = 0;

        $sql = "INSERT INTO t_game (game_id, date_time, is_won_by_player, rounds_num, nickname_id) ";
        $sql .= "VALUES (NULL, :date_time, :is_won_by_player, :rounds_num, :nickname_id)";
        $stmt = $dbconn->prepare($sql);

        $stmt->bindParam(':date_time', $date_time);
        $stmt->bindParam(':is_won_by_player', $is_won_by_player);
        $stmt->bindParam(':rounds_num', $rounds_num);
        $stmt->bindParam(':nickname_id', $nickname_id);
        $stmt->execute();
        $dbconn = null;
    }

    function updateGameStatusById($game_id) {
        
            $dbconn = $this->conn;
    
            $data = [
                'game_id' => $game_id,
                'is_won_by_player' => 1
            ];
    
            $sql = "UPDATE t_game SET is_won_by_player=:is_won_by_player WHERE game_id=:game_id";
    
            $stmt = $dbconn->prepare($sql);
            $stmt->execute($data);
    
            $dbconn = null;
    }

    function getLastGameId() {

        $dbconn = $this->conn;
        $sql = "SELECT game_id FROM t_game";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $gameIdArr = array();
        
        foreach ($rows as $key => $val) {
            $gameIdArr[] = $val['game_id'];
        }

        $lastIndex = count($gameIdArr) - 1;
        return $gameIdArr[$lastIndex];
    }

    function getCurrentGameId() {

        $dbconn = $this->conn;
        $sql = "SELECT game_id FROM t_game ORDER BY game_id DESC LIMIT 1"; // gets last game_id
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($rows)) {
            return $rows[0]['game_id'];
        } else {
            $rows[0]['game_id'] = 1;
            return $rows[0]['game_id'];
        }
        
    }

    function getRoundsByGameId($game_id) {

        $dbconn = $this->conn;
        $sql = "SELECT rounds_num FROM t_game WHERE game_id=" . $game_id;
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $res = array();

        foreach ($rows as $key => $val) {
            $res[] = $val['rounds_num'];
        }

        return $res[0];
    }

    function getNicknameIdByGameId($game_id) {

        $dbconn = $this->conn;
        $sql = "SELECT nickname_id FROM t_game WHERE game_id=" . $game_id;
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $rows[0]['nickname_id'];
    }

    function deleteGameById($game_id) {
        $dbconn = $this->conn;
        $sql = "DELETE FROM t_game WHERE game_id=" . $game_id;
        $dbconn->exec($sql);
        $dbconn = null;
    }

    function finishGame($game_id) {
        
        $dbconn = $this->conn;

        $data = [
            'game_id' => $game_id,
            'is_finisehd' => 1
        ];

        $sql = "UPDATE t_game SET is_finished=:is_finished WHERE game_id=:game_id";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute($data);

        $dbconn = null;
    }


}


?>