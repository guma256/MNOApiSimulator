<?php

class Mtn_Model extends Model {

    function __construct() {
        parent::__construct();

		require_once "vendor/autoload.php";
    }


		public function AlertBigAmounts () {

		$this->logs->ExeLog('Incidents_Model::AlertBigAmounts Initiated ', 1);


        $array_types =array('deposit','withdraw');
      //$array_types =array('deposit');
      $head_array =array('DEPOSITS','WITHDRAWALS');
	    $cur_date=date("Y-m-d");
		  $minutes  =MINUTES_AMOUNTS;
		  //$minutes  =200;

		 $constants =get_defined_constants(true)['user']; //user defined constants
			$date_time_to = date("Y-m-d H:i:s");
			//$date_time_to = date("2020-05-20 08:05:10");
			$timestamp = strtotime($date_time_to);
			$time = $timestamp - ($minutes * 60);
			$datetime_from = date("Y-m-d H:i:s", $time);
		  	$output='';
		//print_r("in ".$minutes);die();
		foreach($array_types as $key=>$val){
                	$output='';
			$amount=$constants[$head_array[$key]];

  //                      $output .= "\t \t BIG  ".$head_array[$key]."  AMOUNTS ALERT".PHP_EOL;
                        $output .= $head_array[$key]."  AMOUNTS ALERT".PHP_EOL;
			$transactions=$this->GetBigAccounts($val,$amount,$datetime_from,$date_time_to);
				//print_r($transactions);die();
		 if(empty($transactions)==false){

	   $counter=1;
   foreach($transactions as $transaction){
		//$values = [];
    $output .= '#'.$counter.PHP_EOL;
    $output .= 'GW Ref  | '.$transaction['transaction_id'].PHP_EOL;
    $output .= 'Time    | '.date("H:i:s", strtotime($transaction['transaction_date'])).PHP_EOL;
    $output .= 'Msisdn  | '.$transaction['account_number'].PHP_EOL;
    $output .= 'Amount  | '.number_format($transaction['transaction_amount']).PHP_EOL;
    $output .= 'MNO     | '.$transaction['operator_name'].PHP_EOL;
    $output .= 'MNO Ref | '.$transaction['payment_ref'].PHP_EOL;
    $output .= 'FSB Ref | '.$transaction['transaction_ref'].PHP_EOL;

     $counter = $counter +1;
     //Update //
		 $id=$transaction['transaction_id'];
		 $postData = array('big_amount'=>1);
	 	 $this->UpdateData('bl_payment_transactions', $postData, "transaction_id = {$id}");

   }
	 //print_r($output);die();

	 $message_send ='```'.$output.'```';
$this->sendToSlack($message_send);
          exit();
	        	}

				 }

	    }

		public function RunAlertChecks () {


	$datetime_from = date("Y-m-d H:i:s", $time);

		//print_r($output);die();
		foreach($array_types as $key=>$val){

			$type_sum=$this->GetSuspiciousAccounts($val,$occurances,$datetime_from,$date_time_to);
			//print_r($type_sum);die();
		 if(empty($type_sum)==false){

	 //print_r($output);die();

	 $message_send ='```'.$output.'```';

	        	}

				 }

	    }



}
