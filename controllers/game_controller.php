<?php 

require_once './controllers/Controller.php';
require_once './model/game_model/GameDao.php';
require_once './model/nickname_model/NicknameDao.php';

class GameController extends Controller{

    public function __construct() {
    }

    public function gamesProvider() {
        $game_dao = new GameDao();
        $data = $game_dao->getAllGames();
        echo json_encode($data);
    }
        
    function startGame() {

        $data = json_decode(file_get_contents('php://input'), true); 

        if (!empty($data['nickname_id']) && !empty($data['rounds_num'])) {

            $nickname_dao = new NicknameDao(); 
            $game_dao = new GameDao(); 

            $nickname_id = $game_rounds = $data['nickname_id']; 
            $nickname_id = $this->escapeInput($nickname_id); 

            $rounds_num = $data['rounds_num']; 
            $rounds_num = $this->escapeInput($rounds_num); 

            $game_dao->insertGame($rounds_num, $nickname_id); 
            $this->gamesProvider();
        }
    }

    function finishGame() {

        $data = json_decode(file_get_contents('php://input'), true);

        if (!empty($data['game_id'])) {

            $game_id = $data['game_id'];
            $game_dao = new GameDao();
            $game_dao->updateGameStatusById($game_id);
        }
    }

}

?>