<?php

class Controller {
    
    public function __construct() {
    }

    function escapeInput($input) {
        if (!empty($input)) {
            $input = trim($input);
            $input = stripslashes($input);
            $input =  htmlspecialchars($input);
            return $input;
        } 
    }

}

?>