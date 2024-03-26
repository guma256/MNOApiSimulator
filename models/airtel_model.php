<?php

class Airtel_Model extends Model {

    function __construct() {
        parent::__construct();

    }




	function ProcessMerchant($version,$payments,$reference=false){
         if($reference!=false){

         }else{

     $response = this->ProcessDebit();
         }
	}




	function ProcessDebit($reference){

	}

	function ProcessStatus($reference){

	}


    function ProcessTokenResponse(){

      $token_arry = array("token_type"=>"bearer",
      "access_token"=>"sjtPZQuIFW1NhNnC8XNbFlxndwyhUcnq",
      "expires_in"=>180);

      echo json_encode($token_arry);


    }


  function ProcessWithdrawTransaction($data){

    $req_data = json_decode($data,true);
    $transaction_id = mt_rand(1, 100000);
    //print_r($data);die();
    $response = array (
        'data' => 
        array (
          'transaction' => 
          array (
            'reference_id' =>  $transaction_id,
            'airtel_money_id' => 'disburs-'.$this->generateRandomString().'-'.$req_data['transaction']['id'],
            'id' => $req_data['transaction']['id'],
            'status' => 'TS',
          ),
        ),
        'status' => 
        array (
          'response_code' => 'DP00900001001',
          'code' => '200',
          'success' => true,
          'result_code' => 'ESB000010',
          'message' =>  $transaction_id.'. Ksh 63.00 deposited to BG Test 010190 on '.date("d/m/y") .' at '.date("g:i a").'. New float balance: Ksh 98896.00.',
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
