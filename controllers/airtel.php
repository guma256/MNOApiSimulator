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

      $this->model->ProcessMerchant($version,$payments,$reference); 
    }

   // /standard/v1/disbursements/
    public function standard($version,$disbursement,$transaction_id=false) {

        $request = file_get_contents('php://input');
    $this->model->ProcessWithdrawTransaction($request);
    }

    ///auth/oauth2/token
    public function auth($autho2,$token) {
      
        $this->model->ProcessTokenResponse();
    }
    


}
?>