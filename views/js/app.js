$(document).ready(function() {

    let selectors = {

        fieldsetFrame: $('#fieldset-frame'),
        regNicknameBtn: $('#reg-nickname-btn'),
        inputRoundOptions: $('#rounds'),
        registeredNicknames: $('#registered-nicknames'),
        userIcon: $('#user-icon'),
        inputNickname: $('#nickname'),
        start: $('#start-btn'),
        infoModal: $('#infoModal'),
        infoMsg: $('#infoMsg'),
        stoneBtn: $('#stone'),
        scisorsBtn: $('#scisors'),
        paperBtn: $('#paper'),
        newGameBtn: $('#new-game-btn'),
        roundN: $('#round-number'),
        yourPoints: $('#all-player-points'),
        pcPoints: $('#all-pc-points'),
        yourChoice: $('#your-choice'),
        pcChoice: $('#pc-choice'),
        winner: $('#game-winner'),
        actionGrid: $('#action-grid'),
        resultGrid: $('#result-grid'),
        shortlist: $('#shortlist')
    };

    let state = {
        current_game_id: 0,
        game_rounds: 0,
        nicknames: [],
        nickname_id: 0,
        nickname: '',
        rounds: [],
        round_num: 0,
        player_choice: '',
        pc_choice: '',
        all_layer_points: [],
        all_pc_points: [],
        current_player_point: 0,
        current_pc_point: 0,
        player_score: 0,
        pc_score: 0,
        list_of_top_5: [],
        winner: '',
        winners: [],
        games_won: [],
        games_won_num: 0,
        is_game_started: 0
    };

    initNicknames();

    selectors.actionGrid.hide();
    selectors.resultGrid.hide();
    selectors.newGameBtn.hide();
    
    function isValidNicknameInput(input) {

        let procedureArr = [];

        var escapeHtml = function(text) {
            return text
                .replace(/&/g, "&amp;")
                .replace(/</g, "&lt;")
                .replace(/>/g, "&gt;")
                .replace(/"/g, "&quot;")
                .replace(/'/g, "&#039;");
        }
       
        escapeHtml(input.nickname).trim();

        if (input.nickname === '' || input.nickname === null
            || input.nickname === 'Register New Nickname') {

                let msgNickname = '<h2 style="color:red;">';
                msgNickname += 'Your must enter a valid Nickname!';
                msgNickname += '</h2>';
                selectors.infoMsg.html(msgNickname);
                selectors.infoModal.modal('toggle');
                procedureArr.push(msgNickname);
        }

        /*
        let nicknameRegEx = /^[a-zA-Z]+$/;                   
        if (!nicknameRegEx.test(input.nickname)) {                   
            procedureArr.push('Invalid Nick Name!');
        }
        */

        if (input.nickname.length > 50) {
            let msgNicknameLn = '<h2 style="color:red;">';
            msgNicknameLn += 'Your Nickname must contain less than 50 characters!';
            msgNicknameLn += '</h2>';
            selectors.infoMsg.html(msgNicknameLn);
            selectors.infoModal.modal('toggle');
            procedureArr.push(msgNicknameLn);
        }

        let isRegisteredNickname = hasRegisteredNickname(input.nickname, state.nicknames);

        if (isRegisteredNickname) {

            let msgNicknameRegistered = '<h2 style="color:red;">';
            msgNicknameRegistered += 'This Nick Name is already used!';
            msgNicknameRegistered += '</h2>';
            selectors.infoMsg.html(msgNicknameRegistered);
            selectors.infoModal.modal('toggle');
            procedureArr.push(msgNicknameRegistered);
        }

        if (procedureArr.length > 0) {                       
            return false;
        } else {
            return true;
        }
    }

    function isValidGameInput(input) {

        let procedureArr = [];

        let selectedNicknamesIndex = document.getElementById("registered-nicknames").selectedIndex;
        let selectedRoundsIdx = document.getElementById("rounds").selectedIndex;

        if (selectedNicknamesIndex === 0 && selectedRoundsIdx !== 0) {
            let msgNicknames = '<h2 style="color:red;">';
            msgNicknames += 'You have to select a range of Nicknames ! </h2>';
            selectors.infoMsg.html(msgNicknames);
            selectors.infoModal.modal('toggle');
            procedureArr.push(msgNicknames);
        }
        
        
        if (selectedRoundsIdx === 0 && selectedNicknamesIndex !== 0) {
            let msgRounds = '<h2 style="color:red;">';
            msgRounds += 'You have to select a range of rounds from 3 to 10! </h2>';
            selectors.infoMsg.html(msgRounds);
            selectors.infoModal.modal('toggle');
            procedureArr.push(msgRounds);
        }

        if (selectedNicknamesIndex === 0 && selectedRoundsIdx === 0) {
            let msg = '<h2 style="color:red;">';
            msg += 'You have to select a range of nicknames'
            msg += 'and a range of rounds from 3 to 10!</h2>';
            selectors.infoMsg.html(msg);
            selectors.infoModal.modal('toggle');
            procedureArr.push(msg);
        }
            
        if (procedureArr.length > 0) {                       
            return false;
        } else {
            return true;
        }
    }

    selectors.regNicknameBtn.click(function() {
        
        let nickname = selectors.inputNickname.val();

        let input = {
            nickname: nickname 
        };

        if (isValidNicknameInput(input)) {
            
            saveNickname(input);
            
            let msgNewNickname = '<h2 style="color:green;"> Your Nickname is saved! </h2>';
            selectors.infoMsg.html(msgNewNickname);
            selectors.infoModal.modal('toggle');
        }
    });

    function saveNickname(input) {

        let data = JSON.stringify(input);
        let url = './index.php?save_nickname';

        let promise = new Promise(function(resolve, reject) {

            let req = new XMLHttpRequest();					
            req.responseType = 'json';
            req.open("POST", url, true);
            req.onload = function() { 
                resolve(req.response)
            }; 
            req.onerror = function() { 
                reject(req.statusText);
            }; 
            req.send(data);
        });

        promise.then(function(){
            initNicknames();
        });

        return promise;
    }

    function getNicknameIdByNickname(nickname) {
        
        let nicknames = state.nicknames;
        let nickname_id;
        
        for (let i = 0; i < nicknames.length; i++) {
            if (nicknames[i].nickname === nickname) {
                nickname_id = nicknames[i].nickname_id;
                break;
            }
        }

        return nickname_id;
    }

    selectors.registeredNicknames.on('change', function() {
        selectors.inputNickname.val(null);
    });

    function getGameRoundByOptVal(optionRoundVal) {
        
        switch(optionRoundVal){
            case '1':
                return 3;
                break;
            case '2': 
                return 5;
                break;
            case '3':
                return 7;
                break;
            case '4':
                return 9
                break;     
        }
    }

    selectors.start.click(function() {

        let selectedNicknamesIndex = document.getElementById("registered-nicknames").selectedIndex;

        let nickname = document.getElementsByTagName("option")[selectedNicknamesIndex].innerText;
        let nickname_id = getNicknameIdByNickname(nickname);

        let selectedRoundIdx = document.getElementById("rounds").selectedIndex;
        let optionRoundVal = document.getElementsByTagName("option")[selectedRoundIdx].value;
        let game_rounds = getGameRoundByOptVal(optionRoundVal);

        let input = {
            rounds_num: game_rounds,
            nickname_id: nickname_id
        };

        if (isValidGameInput(input)) {

            state.game_rounds = input.rounds_num;
            state.nickname_id = input.nickname_id;
            state.nickname = nickname;
            state.round_num = 1;
            state.is_game_started = 1;

            let data = JSON.stringify(input);
            let url = './index.php?start_game';

            let promise = new Promise(function(resolve, reject) { 
                let req = new XMLHttpRequest();					
                req.responseType = 'json';
                req.open("POST", url, true);
                req.onload = function() { 
                    resolve(req.response)
                }; 
                req.onerror = function() { 
                    reject(req.statusText);
                }; 
                req.send(data);
            });

            promise.then(function() {
                initGames();
                initShortList();
                selectors.actionGrid.show();
                selectors.resultGrid.show();
            });
            
            promise.then(function() {

                selectors.registeredNicknames.hide();
                selectors.inputNickname.hide();
                selectors.userIcon.hide();
                selectors.start.hide();
                selectors.inputRoundOptions.hide();
                selectors.regNicknameBtn.hide();

                document.getElementById("fieldset-frame").style.height="168px"; 
            });
            
            return promise;
        }
    });

    function saveRound(input) {
            
        let data = JSON.stringify(input);
        let url = './index.php?save_round';

        let promise = new Promise(function(resolve, reject) { 
            let req = new XMLHttpRequest();					
            req.responseType = 'json';
            req.open("POST", url, true);
            req.onload = function() { 
                resolve(req.response)
            }; 
            req.onerror = function() { 
                reject(req.statusText);
            }; 
            req.send(data);
        })

        promise.then(function() {
            initRounds();
        });

        return promise;
    }

    function playNewGame() {
        location.reload();
    }

    selectors.newGameBtn.click(function(){
        playNewGame();
    });

    function setPoints(are_equals, player_choice, pc_choice) {

        if (!are_equals) {

            if ((player_choice == 'paper' && pc_choice == 'stone')
                || (player_choice == 'stone' && pc_choice == 'scisors')
                || (player_choice == 'scisors' && pc_choice == 'paper')) {

                state.all_layer_points.push(1);
                state.current_player_point = 1;  
                state.current_pc_point = 0;                              

            } else {

                state.all_pc_points.push(1);
                state.current_player_point = 0;
                state.current_pc_point = 1;
            }               
        }
    }

    function finishGame() {

        let input = {
            game_id: state.current_game_id
        };

        let data = JSON.stringify(input);
        let url = './index.php?finish_game';

        let promise = new Promise(function(resolve, reject) {

            let req = new XMLHttpRequest();					
            req.responseType = 'json';
            req.open("POST", url, true);
            req.onload = function() { 
                resolve(req.response)
            }; 
            req.onerror = function() { 
                reject(req.statusText);
            }; 
            req.send(data);
        });

        promise.then(function(){
            document.getElementById("fieldset-frame").style.height="86px"; 
        });

        return promise;
    }

    function getVictoriesByWinner() {

        let winnersData = state.winners;

        for (let i = 0; i < winnersData.length; i++) {
            
            if (winnersData[i].winner === state.winner) {
                return winnersData[i].games_won_num;
            }
        }

        return 0;
    }

    function scoreResult() {

        if (state.rounds.length === parseInt(state.game_rounds)) {
            
            if (state.player_score > state.pc_score) {
                
                state.winner = state.nickname;
                selectors.winner.text(`${state.winner}`);

            } else if (state.player_score < state.pc_score) {
                state.winner = 'Computer';
                selectors.winner.text('Computer!');
            }
        }

        let input = {
            winner: state.winner
        };

        let strVictories = getVictoriesByWinner();
        let victories = parseInt(strVictories);

        if (victories === 0) {
            input.games_won_num = 1; // !!
        }

        if (victories >= 0) {           
            if (victories <= state.games_won_num) {
                state.games_won.push(1);
                state.games_won_num = victories;
            }
        }

        if (victories > 0) {
            input.games_won_num = victories += 1; // !!
        }

        let data = JSON.stringify(input);

        let url = './index.php?score_result';

        let promise = new Promise(function(resolve, reject) {

            let req = new XMLHttpRequest();					
            req.responseType = 'json';
            req.open("POST", url, true);
            req.onload = function() { 
                resolve(req.response)
            }; 
            req.onerror = function() { 
                reject(req.statusText);
            }; 
            req.send(data);
        });

        promise.then(function() {
            initGames();
            initShortList();
        });

        return promise;
    }

    function initShortList() {

        let promise =  new Promise(function(resolve, reject) {

            let url = './index.php?winners';

            let req = new XMLHttpRequest();
            req.open('GET', url, true);						
            req.responseType = 'json';

            req.onload = function() {
                resolve(req.response)
            };

            req.onerror = function() {
                reject(req.statusText);
            };

            req.send();

        })

        promise.then(function(response) {

            for (let i = 0; i < response.length; i++) {
            
                state.winners.push({
                    winner_id: response[i].winner_id,
                    winner: response[i].winner,
                    games_won_num: response[i].games_won_num
                });        
            }
            
        });

        promise.then(function(response) {

            if (response !== undefined && response !== null
                && response.length > 0 && state.winners.length > 0) {
   
                let out = '';

                for (let j = 0; j < response.length; j++) {
                    out += '<li>';
                    out += response[j].winner;
                    out += ' / ';
                    out += response[j].games_won_num;
                    out += '</li>';
                }
                selectors.shortlist.html(out);
            }
        });

        return promise;
    }
    
    function makeChoice(input) {

        let current_round_num = state.rounds.length + 1;

        if (input.player_choice === input.pc_choice ) {
            let msgEq = '<h2 style="color:red;"> Equal choices - play again! </h2>';
            selectors.infoMsg.html(msgEq);
            selectors.infoModal.modal('toggle');
            return;
        } 
        
        if (current_round_num <= state.game_rounds) {

            state.rounds.push(1);
            setPoints(false, input.player_choice, input.pc_choice);
            state.round_num = state.rounds.length;

            input.round_num = state.round_num; // !!
            input.player_point = state.current_player_point; // !!
            input.pc_point = state.current_pc_point; // !!

            state.player_choice = input.player_choice; 
            state.pc_choice = input.pc_choice;
            state.player_score = state.all_layer_points.length; 
            state.pc_score = state.all_pc_points.length; 
            saveRound(input);
            updateHtml();
            if (current_round_num < state.game_rounds) {
                let msgSaved = '<h2 style="color:green;"> Your choice is saved! </h2>';
                selectors.infoMsg.html(msgSaved);
                selectors.infoModal.modal('toggle');
            }
            
            if (state.rounds.length === parseInt(state.game_rounds)) {             
                finishGame();
                scoreResult();
                selectors.actionGrid.hide();
                selectors.newGameBtn.show();
                selectors.inputRoundOptions.hide();
                selectors.userIcon.hide();
                selectors.inputNickname.hide();
                selectors.start.hide();
                document.getElementById("fieldset-frame").style.height="166px";
                updateHtml();
                let msgFinished = '<h2 style="color:green;"> Your choice is saved! </h2>';
                msgFinished += '<h2 style="color:red;"> Game Over! </h2>';
                selectors.infoMsg.html(msgFinished);
                selectors.infoModal.modal('toggle');
                return;
            } 
        }
    }
    
    selectors.stoneBtn.click(function() {

        let input = {
            game_id: state.current_game_id,
            player_choice: 'stone',
            pc_choice: getPcChoice()
        };

        makeChoice(input);

    });

    selectors.scisorsBtn.click(function() {
        
        let input = {
            game_id: state.current_game_id,
            player_choice: 'scisors',
            pc_choice: getPcChoice()
        }; 

        makeChoice(input);
        
    });

    selectors.paperBtn.click(function() {
        
        let input = {
            game_id: state.current_game_id,
            player_choice: 'paper',
            pc_choice: getPcChoice()
        };  

        makeChoice(input);

    });

    function initNicknames() {

        let promise =  new Promise(function(resolve, reject) {

            let url = './index.php?nicknames';

            let req = new XMLHttpRequest();
            req.open('GET', url, true);						
            req.responseType = 'json';

            req.onload = function() {
                resolve(req.response)
            };

            req.onerror = function() {
                reject(req.statusText);
            };

            req.send();

        })

        promise.then(function(response){
            
            for (let i = 0; i < response.length; i++) {
                
                let obj = {
                    nickname_id: response[i].nickname_id,
                    nickname: response[i].nickname
                };
                
                state.nicknames.push(obj);
            }
        });

        promise.then(function(response) {

            let out = '<option selected> -------- SELECT REGISTERED NICKNAME ------ </option>';
            for(let i = 0; i < response.length; i++) {
                out += '<option value=';
                out += response[i].nickname_id;
                out += '>';
                out += response[i].nickname;
                out += '</option>';
            }
            selectors.registeredNicknames.html(out);
            
        });

        return promise;

    }

    function initGames() {

        let promise =  new Promise(function(resolve, reject) {

            let url = './index.php?games';

            let req = new XMLHttpRequest();
            req.open('GET', url, true);						
            req.responseType = 'json';

            req.onload = function() {
                resolve(req.response)
            };

            req.onerror = function() {
                reject(req.statusText);
            };

            req.send();
        });

        promise.then(function(response){
            
            if (response !== null && response !== undefined 
                && response.length > 0 && state.is_game_started > 0) {

                    let lastIdx = response.length - 1;
                    state.current_game_id = response[lastIdx].game_id;
            }
        })

        return promise;
    }

    function initRounds() {

        let promise =  new Promise(function(resolve, reject) {

            let url = './index.php?rounds';

            let req = new XMLHttpRequest();
            req.open('GET', url, true);						
            req.responseType = 'json';

            req.onload = function() {
                resolve(req.response)
            };

            req.onerror = function() {
                reject(req.statusText);
            };

            req.send();
        });

        return promise;
    }

    function getPcChoice() {
        
        let pc_choice_num = Math.floor(Math.random() * (3 - 1)) + 1;
        let pc_choice = '';

        if (pc_choice_num == 1) {
            pc_choice += 'stone';
        } else if (pc_choice_num == 2) {
            pc_choice += 'scisors';
        } else if (pc_choice_num == 3) {
            pc_choice += 'paper';
        }

        return pc_choice;
    }

    function hasRegisteredNickname(nickname, nicknames) {

        if (nickname !== undefined && nickname !== null
            && nicknames !== undefined && nicknames !== null) {

            for (let i = 0; i < nicknames.length; i++) {
                
                if (nicknames[i].nickname === nickname) {
                    return true;
                } 
            }

            return false;
        }
    }

    function updateHtml() {
        selectors.roundN.text(state.round_num);
        selectors.yourPoints.text(state.player_score);
        selectors.pcPoints.text(state.pc_score);
        selectors.yourChoice.text(state.player_choice);
        selectors.pcChoice.text(state.pc_choice);
    }

}); 