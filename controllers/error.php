<?php

class Errors {

    function __construct() {
        
    }
    
    function Index($error_id, $path_at_error = false){
        echo 'We have error ID '.$error_id.'<br/>';
        echo 'We have error Message '.$path_at_error.'<br/>';
    }

}

