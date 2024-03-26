<?php

class Index extends Controller {

    function __construct() {
        parent::__construct();

    }

    public function index(){

	$response='<operationResult>
	  <response>
	  <responsecode>99</responsecode>
	  <responsemsg>Invalid Request</responsemsg>
	  </response>
	  </operationResult>'; 
  echo $response;
      die();	
    }	




}



?>