<?php

namespace sql_connection;

use stdClass;
use sql_connection\Database;

require_once('env/constants.php');
require_once('./Database.php');

class User {
    private string $_user = '';
    private int $_id = 0;
    private string $_password = '';

    public function __construct() {

        
    }

    private function query_with_filter()
    {
        $db = new Database(MYSQL_CONFIG);

        $params = [':id' => $this->_id];

        $query = $db->execute_query("SELECT * " .
            "FROM usuarios " .
            "WHERE id = :id", $params);
        
        if ($query->affected_rows > 0) {
            echo 'trouxe resultado';
            echo '<pre>';
            print_r($query);
        } else {
            echo 'erro, nao foi encontrado';
        }

    
    }

    public function get_user(string $email, string $password) {



    }

    private function _result($status, $message, $sql, $results, $affected_rows, $last_inserted_id){
        $tmp = new stdClass();
        $tmp->status = $status;
        $tmp->message = $message;
        $tmp->query = $sql;
        $tmp->results = $results;
        $tmp->affected_rows = $affected_rows;
        $tmp->last_inserted_id = $last_inserted_id;
        return $tmp;
    }
}