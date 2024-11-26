<?php

class Model {

    function __construct() {
         $this->logs = new Logs;
    }


    function GetOpenTransactions($t_limit) {
     
     // print_r("SELECT * FROM transactions WHERE status='Pending' FOR UPDATE SKIP LOCKED LIMIT '".$t_limit."' ");
  return $this->db->SelectData("SELECT * FROM transactions WHERE status='Pending' LIMIT $t_limit FOR UPDATE SKIP LOCKED");
    }


    function UpdateStatus($postData,$id) {

      $this->db->UpdateData('transactions', $postData, "id = {$id}");
	}


 

  function SendJSONByCURL($url, $json_req,$worker=false) {
    $cont_len = strlen($json_req);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'cache-control: no-cache', 'Content-Length: ' . $cont_len));
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_req);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

    $content = curl_exec($ch);
    if (!curl_errno($ch)) {
        $info = curl_getinfo($ch);
        $log = 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'];
   // $this->log->TraceLog($worker.'Model::SendJSONByCURL Returning ' . $log, 2);

    } else {
      $error=array();
      $log = 'Curl error: ' . curl_error($ch);
      $error['curlerror_message']=$log;
      $error['error']='Error Occurred';
      $error['curl_errorcode']=curl_errno($ch);
      $content=json_encode($error);
   //   $this->log->ExeLog($worker.'Model::SendJSONByCURL Returning ' . $log, 2);
    }
    curl_close($ch);
//$this->log->ExeLog($worker.'Model::SendJSONByCURL response content '. var_export($content, true), 2);
    return $content;
}


}

?>
