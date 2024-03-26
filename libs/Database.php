<?php

class Database extends PDO {

    public function __construct($params = false) {
        if(empty($params)){
            parent::__construct(DB_TYPE . ':host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
        }
        else{
            parent::__construct(DB_TYPE. ':host=' . $params['host'] . ';dbname=' . $params['name'], $params['user'], $params['pass']);
        }
        
    }

   

    function BeginTransaction(){

        return PDO::beginTransaction();
    }

    public function commit()
    {
   
     return PDO::commit();

    }

    public function rollback()
    {

        return PDO::rollback();
    }


    public function UpdateData($table, $data, $where) {
        ksort($data);
 $fieldlog=null;
        $fieldDetails = NULL;
        foreach ($data as $key => $value) {
            $fieldDetails .= "$key = :$key,";
            $fieldlog .= "$key = :$value,";
        }

        $fieldDetails = rtrim($fieldDetails, ',');

        $sql_statement = "UPDATE $table SET $fieldDetails WHERE $where";

        $sth = $this->prepare($sql_statement);

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
        $now = date('Y-m-d H:i:s');
     /* $user_id = $_SESSION['uid'];

        $logdata = array(
            'log_time' => $now,
            'table_name' => $table,
            'query_executed' => $sql_statement,
            'data_set' => $fieldlog,
            'user_id' => $user_id
        );
       $this->DBOperationLog($logdata); */
    }

    public function SelectData($sql, $data = array(), $fetchMode = PDO::FETCH_ASSOC) {
        $sth = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }

        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }

    public function DeleteData($table, $where, $limit = 1) {
        $sql_statement = "DELETE FROM $table WHERE $where LIMIT $limit";
        return $this->exec($sql_statement);
        $now = date('Y-m-d H:i:s');
       /* $user_id = $_SESSION['uid'];
        $logdata = array(
            'log_time' => $now,
            'table_name' => $table,
            'query_executed' => $sql_statement,
            'user_id' => $user_id
        );
        $this->DBOperationLog($logdata); */
    }

    public function DBOperationLog($data) {
        $fieldNames = implode(', ', array_keys($data));
        $fieldInputs = ':' . implode(', :', array_keys($data));
        $sql_statement = "INSERT INTO tr_system_log 
                    ($fieldNames)
            VALUES  ($fieldInputs)";
        $sth = $this->prepare($sql_statement);
        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        $sth->execute();
    }

}

?>
