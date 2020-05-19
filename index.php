<?php 

require_once './controllers/Controller.php';

$qs = $_SERVER['QUERY_STRING'];

function frontController($qs) {

    switch ($qs) {
        case '/':
            require_once __DIR__ . '/views/index.html';
            break;
        case '':
            require_once __DIR__ . '/views/index.html';
            break;
        case 'nicknames':
            require_once __DIR__ . '/controllers/nickname_controller.php';
            $nickname_controller = new NicknameController();
            $nickname_controller->nicknamesProvider();
            break;
        case 'games':
            require_once __DIR__ . '/controllers/game_controller.php';
            $game_controller = new GameController();
            $game_controller->gamesProvider();
            break;     
        case 'save_nickname':
            require_once __DIR__ . '/controllers/nickname_controller.php';
            $nickname_controller = new NicknameController();
            $nickname_controller->saveNickname();
        case 'rounds':
            require_once __DIR__ . '/controllers/round_controller.php';
            $round_controller = new RoundController();
            $round_controller->roundsProvider();
            break;     
        case 'save_round':
            require_once __DIR__ . '/controllers/round_controller.php';
            $round_controller = new RoundController();
            $round_controller->saveRound();
            break;    
        case 'start_game':
            require_once __DIR__ . '/controllers/game_controller.php';
            $game_controller = new GameController();
            $game_controller->startGame();
            break;  
        case 'finish_game':
            require_once __DIR__ . '/controllers/game_controller.php';
            $game_controller = new GameController();
            $game_controller->finishGame();
            break;
        case 'winners':
            require_once __DIR__ . '/controllers/winner_controller.php';
            $winner_controller = new WinnerController();
            $winner_controller->winnersProvider();
            break;
        case 'score_result':
            require_once __DIR__ . '/controllers/winner_controller.php';
            $winner_controller = new WinnerController();
            $winner_controller->scoreResult();
            break;    
        case 'test':
            // http://localhost/ssp/index.php?test
            require_once __DIR__ . '/model/game_model/GameDao.php';
            require_once __DIR__ . '/model/round_model/RoundDao.php';
            require_once __DIR__ . '/model/winner_model/WinnerDao.php';
            require_once __DIR__ . '/controllers/game_controller.php';
            require_once __DIR__ . '/controllers/round_controller.php';
            require_once __DIR__ . '/controllers/winner_controller.php';
            
            $dao = new WinnerDao();
            echo ($dao->isWinnerExits('Pesho'));
            break;     
        default:
            http_response_code(404);
            require __DIR__ . '/views/404.php';
            break;
    }
}

frontController($qs);

?>