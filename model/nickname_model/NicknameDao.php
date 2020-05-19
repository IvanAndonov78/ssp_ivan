<?php 

require_once './model/db.php';
require_once 'NicknameEntity.php';

class NicknameDao extends Db {

    public function __construct(){
        Db::__construct(); //== parent::__construct();
    }

    function getAllNicknames() {
        
        $dbconn = $this->conn;
        $sql = "SELECT * FROM t_nickname";

        $stmt = $dbconn->prepare($sql);
        $stmt->execute();

        // $rows = $stmt->fetchAll(PDO::FETCH_ASSOC); the lazy way, but not better! :)

        $rows = array();

        while ($row = $stmt->fetch()) {

            $nickname_id = $row['nickname_id'];
            $nickname = $row['nickname'];

            $rs = new NicknameEntity();
            $rs->setNicknameId($nickname_id);
            $rs->setNickname($nickname);

            $rows[] = array(
                'nickname_id' => $rs->getNicknameId(),
                'nickname' => $rs->getNickname()
            );
        }

        return $rows;
    }

    function isRegisteredNickname($nickname) {
        
        $dbconn = $this->conn;
        $sql = "SELECT nickname from t_nickname where nickname=". "'" . $nickname ."'";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        //$stmt->fetch(PDO::FETCH_ASSOC);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) > 0) {
            return true;
        } 

        return false;
    }
    
    function insertNickname($nickname) {
        
        if (!$this->isRegisteredNickname($nickname)) {

            $dbconn = $this->conn;
            $sql = "INSERT INTO t_nickname (nickname_id, nickname) ";
            $sql .= "VALUES (NULL, :nickname)";
            $stmt = $dbconn->prepare($sql);

            $stmt->bindParam(':nickname', $nickname);
            $stmt->execute();
            $dbconn = null;
        } else {
            echo "This player's nickname is already registered! It should be unique!";
        }
    }

    function getLastNicknameId() {

        $dbconn = $this->conn;
        $sql = "SELECT nickname_id FROM t_nickname";
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $nicknameIdArr = array();
        
        foreach ($rows as $key => $val) {
            $nicknameIdArr[] = $val['nickname_id'];
        }

        $lastIndex = count($nicknameIdArr) - 1;
        return $nicknameIdArr[$lastIndex];

    }

    function getCurrentNicknameId() {

        $dbconn = $this->conn;
        $sql = "SELECT nickname_id FROM t_nickname ORDER BY nickname_id DESC LIMIT 1"; // gets last game_id
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (!empty($rows)) {
            return $rows[0]['nickname_id']; // game_id = last nickname_id
        } else {
            $rows[0]['nickname_id'] = 1;
            return $rows[0]['nickname_id']; // game_id = 1
        }
    }

    function getNicknameById($nickname_id) {
        
        $dbconn = $this->conn;
        $sql = "SELECT nickname FROM t_nickname WHERE nickname_id=" . $nickname_id;
        $stmt = $dbconn->prepare($sql);
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $rows[0]['nickname'];
    }


}


?>