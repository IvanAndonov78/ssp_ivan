<?php 

require_once './controllers/Controller.php';
require_once './model/nickname_model/NicknameDao.php';

class NicknameController extends Controller{

    public function __construct() {
    }

    public function nicknamesProvider() {
        $nickname_dao = new NicknameDao();
        $data = $nickname_dao->getAllNicknames();
        echo json_encode($data);
    }

    public function saveNickname() {
        
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!empty($data['nickname'])) {

            $nickname_dao = new NicknameDao();

            $errArr = array(); 
 
            $nickname = $game_rounds = $data['nickname'];
            $nickname = $this->escapeInput($nickname);

            /*
            $nicknameRegEx = "/^[a-zA-Z ]*$/";
            if (!preg_match($nicknameRegEx, $nickname)) {
                $errArr[] = "Invalid Nickname!";
            }
            */

            if (strlen($nickname) > 50) {
                
                $errArr[] = 'The Nickname should be shorter than 50 characters !';
                $res = array();
            }

            if ($nickname_dao->isRegisteredNickname($nickname)) {
                $errArr[] = 'Duplicate Nickname!';
            }
                        
            if (count($errArr) > 0) {

                foreach($errArr as $val) {
                    echo $val;
                }
                return;

            } else {
                $nickname_dao->insertNickname($nickname);
                $this->nicknamesProvider();
            }
            
        }
    }

}

?>