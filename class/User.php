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
    private $user_data = [];

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

        $this->_user = $email;
        //$this->_password = $password;

        $user_exist = $this->check_user_exist();

        if (!$user_exist) {
            return false;
        } else {
            $this->_password = $user_exist[0]->password;
            $eval_password = $this->check_password($password);

            if (!$eval_password){
                return false;
            }

            $this->user_data['name'] = $user_exist[0]->nome;
            $this->user_data['apelido'] = $user_exist[0]->apelido;
            $this->user_data['email'] = $user_exist[0]->email;

            return $this->user_data;
        }

    }

    private function check_user_exist(){
        $db = new Database(MYSQL_CONFIG);

        $params = [':email' => $this->_user];
        $query = $db->execute_query("SELECT * FROM usuarios WHERE email = :email", $params);

        if ($query->affected_rows > 0) {

            return $query->results;
        }

        return false;
    }

    private function check_password(string $password){

        return ($password == $this->_password);
    }

    // private function _result($status, $message, $sql, $results, $affected_rows, $last_inserted_id){
    //     $tmp = new stdClass();
    //     $tmp->status = $status;
    //     $tmp->message = $message;
    //     $tmp->query = $sql;
    //     $tmp->results = $results;
    //     $tmp->affected_rows = $affected_rows;
    //     $tmp->last_inserted_id = $last_inserted_id;
    //     return $tmp;
    // }
}