<?php 

require_once './controllers/Controller.php';
require_once './model/winner_model/WinnerDao.php';

class WinnerController extends Controller{

    public function __construct() {
    }

    public function winnersProvider() {
        $winner_dao = new WinnerDao();
        $data = $winner_dao->getAllWinners();
        echo json_encode($data);
    }

    public function scoreResult() {

        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!empty($data['winner'])) { 

            $winner = $data['winner'];
            $winner = $this->escapeInput($winner);

            $games_won_num = 1; // ???

            if (!empty($data['games_won_num'])) {
                $games_won_num = $data['games_won_num'];
                $games_won_num = $this->escapeInput($games_won_num);
            }

            $winner_dao = new WinnerDao();

            $winner_dao->score($winner, $games_won_num);
        }
    }

    

}

?>