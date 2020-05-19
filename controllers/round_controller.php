<?php 

require_once './controllers/Controller.php';
require_once './model/round_model/RoundDao.php';
require_once './model/game_model/GameDao.php';

class RoundController extends Controller{

    public function __construct() {
    }

    public function roundsProvider() {
        
        $rounds_dao = new RoundDao();
        $rounds = $rounds_dao->getAllRounds();
        
        if (count($rounds) > 0) {
            echo json_encode($rounds);
        } 
    }

    function saveRound() {

        $data = json_decode(file_get_contents('php://input'), true);

        if (!empty($data['game_id']) && !empty($data['player_choice'])
                && !empty($data['pc_choice']) && !empty($data['round_num'])) {

            $game_id = $data['game_id'];
            $game_id = $this->escapeInput($game_id);

            $game_dao = new GameDao();
            $nickname_id = $game_dao->getNicknameIdByGameId($game_id);

            $player_choice = $data['player_choice'];
            $player_choice = $this->escapeInput($player_choice);

            $pc_choice = $data['pc_choice'];
            $pc_choice = $this->escapeInput($pc_choice);

            $player_point = $data['player_point']; 
            $pc_point = $data['pc_point']; 

            $round_num = $data['round_num'];
            $round_num = $this->escapeInput($round_num);

            $round_dao = new RoundDao();

            $round_dao->insertRound($game_id, $player_choice, $pc_choice,  
                            $player_point, $pc_point, $round_num);
                        
        }   
    }

}

?>