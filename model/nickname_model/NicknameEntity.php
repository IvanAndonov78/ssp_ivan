<?php

class NicknameEntity {
    
    private $nickname_id;
    private $nickname;

    public function __construct($nickname_id = null, $nickname = null) {
        $this->nickname_id = $nickname_id;
        $this->nickname = $nickname;
    }

    function getNicknameId(){
        return $this->nickname_id;
    }

    function setNicknameId($nickname_id){
        $this->nickname_id = $nickname_id;
    }

    function getNickname() {
        return $this->nickname;
    }

    function setNickname($nickname) {
        $this->nickname = $nickname;
    }

}

?>
