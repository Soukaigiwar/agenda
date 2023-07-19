<?php

namespace sql_connection;

use stdClass;
use sql_connection\Database;
use UserCrypt;

require_once('env/constants.php');
require_once('Database.php');
require_once('UserCrypt.php');

class User {
    private string $_user = '';
    private int $_user_id = 0;
    private string $_password = '';
    private $user_data = [];

    public function get_user(string $email, string $password) {

        $this->_user = $email;

        $user_exist = $this->check_user_exist();

        if (!$user_exist) {
            return false;
        } else {
            $user_crypt = new UserCrypt();

            $hash = $user_exist[0]->password;

            $eval_password = $user_crypt->check_password($password, $hash);

            if (!$eval_password){
                return false;
            }

            $this->user_data['user_id'] = $user_exist[0]->id;
            $this->user_data['name'] = $user_exist[0]->nome;
            $this->user_data['apelido'] = $user_exist[0]->apelido;
            $this->user_data['email'] = $user_exist[0]->email;

            return $this->user_data;
        }
    }

    public function add_user(array $user_data) {
        $this->_user = $user_data['email'];
        $user_exist = $this->check_user_exist();

        if ($user_exist) {
            return false;
        } else {
            $db = new Database(MYSQL_CONFIG);

            $passwordCrypt = new UserCrypt();
            $password = $passwordCrypt->setPassword($user_data['password']);

            $params = [
                ':nome' => $user_data['name'],
                ':apelido' => $user_data['last_name'],
                ':email' => $user_data['email'],
                ':password' => $password
            ];

            $query = $db->execute_non_query("INSERT INTO `usuarios` " .
                "VALUES (0, :nome, :apelido, :email, :password, NOW(), NOW(), null)", $params);
            
            $status = $query->status;
            $message = $query->message;
            $sql = $query->query;
            $results = $query->results;
            $affected_rows = $query->affected_rows;
            $last_inserted_id = $query->last_inserted_id;

            return $this->_result($status, $message, $sql, $results, $affected_rows, $last_inserted_id);
        }
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

    private function check_user_exist(){
        $db = new Database(MYSQL_CONFIG);

        $params = [':email' => $this->_user];
        $query = $db->execute_query("SELECT * FROM usuarios WHERE email = :email", $params);

        if ($query->affected_rows > 0) {

            return $query->results;
        }

        return false;
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
