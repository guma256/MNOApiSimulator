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
  
    $statuses=array("0"=>"TS","1"=>"TF","2"=>"TA","3"=>"TIP");
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
    
    $statuses=array("0"=>"TS","1"=>"TF","2"=>"TA","3"=>"TIP");
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

}
