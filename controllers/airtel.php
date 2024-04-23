<?php

class Airtel extends Controller {

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

///merchant/v1/payments/
// /standard/v1/payments/BL-

    public function merchant($version,$payments,$reference=false) {
            $request = file_get_contents('php://input');
            if (empty($request)) {
    
                    $response=array();
                    $response['status'] = 'Failed';
                    $response['message'] = 'System failed to interprete Request Received';
                    header('Content-Type: application/json;charset=utf-8');
                    echo json_encode($response);
                }else{
      $this->model->ProcessMerchant($version,$payments,$request,$reference); 
                }
    }
  
   // /standard/v1/disbursements/
    public function standard($version,$disbursement,$transaction_id=false) {
         if($transaction_id==false){
        $request = file_get_contents('php://input');
        if (empty($request)) {

            	$response=array();
    			$response['status'] = 'Failed';
                $response['message'] = 'System failed to interprete Request Received';
                header('Content-Type: application/json;charset=utf-8');
                echo json_encode($response);
	        }else{
    $this->model->ProcessWithdrawTransaction($request);
            }

        }else{
            $this->model->ProcessStatusRequest($disbursement,$transaction_id);
        }
    }

    ///auth/oauth2/token
    public function auth($autho2,$token) {
      
        $this->model->ProcessTokenResponse();
    }
    


}
?>
