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


 



}

?>
