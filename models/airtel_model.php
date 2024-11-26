<?php

class Airtel_Model extends Model {

    function __construct() {
        parent::__construct();

    }




	function ProcessMerchant($version,$payments,$request,$reference){
         if($reference!=false){

         }else{

     $response = $this->ProcessDebit($request);
         }
	}




	function ProcessDebit($request){


  $arrayVar = [
      "data" => [
          "transaction" => [
              "id" => mt_rand(1, 10000000),
              "status" => "Success.",
          ],
      ],
      "status" => [
          "response_code" => "DP00800001006",
          "code" => "200",
          "success" => true,
          "result_code" => "ESB000010",
          "message" => "Success.",
      ],
  ];
  
   
  $this->ReleaseClient(json_encode($arrayVar));
    
   
    //$statuses=array("0"=>"TS","1"=>"TF","2"=>"TA","3"=>"TIP");
    $statuses=array("0"=>"TS","1"=>"TF");
    $message=array("0"=>"Your Request is submitted Successfully","1"=>"Transaction failed","2"=>"Ambiguous transaction","3"=>"Transaction in Progress");
    $key = array_rand($statuses,1);
    $req_data = json_decode($request,true);
    $transaction_id = mt_rand(1, 100000);
    //print_r($request);die();
        if($statuses[$key]=='TS'){
          $airtel_money_id = 'Debits-'.$this->generateRandomString();
          $successful = [
            "transaction" => [
                "status_code" => $statuses[$key],
                "code" => "DP008001001",
                "airtel_money_id" => $airtel_money_id,
                "id" => $req_data['transaction']['id'],
                "message" => $message[$key]." Airtel Money ID ".$airtel_money_id
            ],
        ];
        $request = $this->SendJSONByCURL(gw_callback.'airtelmoney/callback',json_encode($successful));
        exit();

        }else if ($statuses[$key]=='TA'){
          $transaction_id = 'null';
          $airtel_money_id = 'null';
          exit();
        }else if($statuses[$key]=='TIP'){
          $transaction_id = 'null';
          $airtel_money_id = 'null';
          exit();
        }else{

          $airtel_money_id = 'null';
          $failed = [
            "transaction" => [
                "status_code" => $statuses[$key],
                "code" => "DP008001013",
                "airtel_money_id" => $airtel_money_id,
                "id" => $req_data['transaction']['id'],
                "message" => $message[$key],
            ],
        ];
        $request = $this->SendJSONByCURL(gw_callback.'airtelmoney/callback',json_encode($failed));
        exit();
        }
    $response = array (
        'data' => 
        array (
          'transaction' => 
          array (
            'reference_id' =>  $transaction_id,
            'airtel_money_id' => $airtel_money_id,
            'id' => $req_data['transaction']['id'],
            'status' => $statuses[$key],
          ),
        ),
        'status' => 
        array (
          'response_code' => 'DP00900001001',
          'code' => '200',
          'success' => true,
          'result_code' => 'ESB000010',
          'message' => $message[$key],
        ),
    );

    echo json_encode($response);

	}

	function ProcessStatusRequest($operation,$transaction_id){
     
    $statuses=array("0"=>"TS","1"=>"TF","2"=>"TA","3"=>"TIP");
    $message=array("0"=>"Your Request is submitted Successfully","1"=>"Transaction failed","2"=>"Ambiguous transaction","3"=>"Transaction in Progress");

    $key = array_rand($statuses,1);
    $req_data = json_decode($data,true);
    $AM_id = mt_rand(1, 100000);
    //print_r($key);die();
    if($operation=='disbursements'){
    $response = array (
        'data' => 
        array (
          'transaction' => 
          array (
            'id' =>  $transaction_id,
            'message' => $message[$key],
            'status' => $statuses[$key],
          ),
        ),
        'status' => 
        array (
          'response_code' => 'DP00900001001',
          'code' => '200',
          'success' => true,
          'result_code' => 'ESB000010',
          'message' =>  'SUCCESS',
        ),
    );
  }else{

    $message=array("0"=>"Success","1"=>"Transaction failed","2"=>"Ambiguous transaction","3"=>"Transaction in Progress");

    $response = array (
      'data' => 
      array (
        'transaction' => 
        array (
          'airtel_money_id' => 'AM-'.$AM_id,
          'id' => $transaction_id,
          'message' =>$message[$key],
          'status' => $statuses[$key],
        ),
      ),
      'status' => 
      array (
        'response_code' => 'DP00900001001',
        'code' => '200',
        'success' => true,
        'result_code' => 'ESB000010',
        'message' => 'SUCCESS',
      ),
  );

  }
  header('Content-Type: application/json;charset=utf-8');
    echo json_encode($response);
	}


    function ProcessTokenResponse(){

      $token_arry = array("token_type"=>"bearer",
      "access_token"=>"sjtPZQuIFW1NhNnC8XNbFlxndwyhUcnq",
      "expires_in"=>180);

      echo json_encode($token_arry);


    }


  function ProcessWithdrawTransaction($data){
    
    //$statuses=array("0"=>"TS","1"=>"TF","2"=>"TA","3"=>"TIP");
    $statuses=array("0"=>"TS");
    $message=array("0"=>"Your Request is submitted Successfully","1"=>"Transaction failed","2"=>"Ambiguous transaction","3"=>"Transaction in Progress");
    $key = array_rand($statuses,1);
    $req_data = json_decode($data,true);
    $transaction_id = mt_rand(1, 100000);
    //print_r($data);die();
        if($statuses[$key]=='TS'){
          $airtel_money_id = 'disburs-'.$this->generateRandomString().'-'.$req_data['transaction']['id'];
        }else if ($statuses[$key]=='TA'){
          $transaction_id = 'null';
          $airtel_money_id = 'null';
        }else if($statuses[$key]=='TIP'){
          $transaction_id = 'null';
          $airtel_money_id = 'null';
        }else{

        }
    $response = array (
        'data' => 
        array (
          'transaction' => 
          array (
            'reference_id' =>  $transaction_id,
            'airtel_money_id' => $airtel_money_id,
            'id' => $req_data['transaction']['id'],
            'status' => $statuses[$key],
          ),
        ),
        'status' => 
        array (
          'response_code' => 'DP00900001001',
          'code' => '200',
          'success' => true,
          'result_code' => 'ESB000010',
          'message' => $message[$key],
        ),
    );


    echo json_encode($response);


  }


  function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}


function ReleaseClient($response){


  while(ob_get_level())ob_end_clean();
  ignore_user_abort();
    ob_start();
    // do initial processing here
    // Disable compression (in case content length is compressed).
    header('Content-Type: application/json');
    header("Content-Length: " . strlen($response)); // Set correct Content-Length header
    header("Content-Encoding: none");
    // Close the connection.
   // Send the response
    echo $response;
    header("Connection: close");
    // Flush all output.
    ob_end_flush();
    if (ob_get_level() > 0) {ob_flush();}
    flush();

  if (is_callable('fastcgi_finish_request')) {
  fastcgi_finish_request();// important when using php-fpm! &  Nginx
  }
 
 // Close current session (if it exists).
 if (session_id()) {
   session_write_close();
 }
     //continue processing
    // sleep(20);

}

}
