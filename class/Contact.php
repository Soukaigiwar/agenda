<?php

namespace sql_connection;

use stdClass;
use sql_connection\Database;
use CustomException;

require_once('env/constants.php');
require_once('class/Database.php');
require_once('class/CustomException.php');

class Contact {
    private ?string $_search = '';
    private ?string $_search_nome;
    private ?string $_search_telefone;
    private int $_contact_id = 0;
    private int $_user_id;

    public function __construct(){
        $this->_user_id = $_SESSION['user_id'];
    }

    private function query_with_filter() {
        
        $db = new Database(MYSQL_CONFIG);
        
        if($this->_search != ''){

            $params = [
                ':user_id' => $this->_user_id,
                ':search' => '%' . trim($this->_search) . '%'
                ];
            if (is_numeric($this->_search)) {
                $query = $db->execute_query("SELECT * FROM telefones
                    WHERE user_id = :user_id 
                    AND telefone LIKE :search 
                    ORDER BY created_at DESC", $params);
            } else {
                $query = $db->execute_query("SELECT * FROM telefones
                    WHERE user_id = :user_id 
                    AND nome LIKE :search 
                    ORDER BY created_at DESC", $params);
            }
        }
        
        if($this->_contact_id != null) {
            $params = [
                ':user_id' => $this->_user_id,
                ':id' => $this->_contact_id
            ];
            $query = $db->execute_query("SELECT * FROM telefones 
                WHERE user_id = :user_id
                AND id = :id 
                ", $params);
            return $query;
        }
        return $query;
    }

    private function query_without_filter() {
        $db = new Database(MYSQL_CONFIG);
        $params = [
            ':user_id' => $this->_user_id
        ];
        $query = $db->execute_query("SELECT * FROM telefones 
            WHERE user_id = :user_id
            ORDER BY created_at DESC", $params);
        
        return $query;
    }

    public function get_contacts(string $search) {

        $query = null;
        $this->_search = $search;
        
        if($this->_search != ''){
            $query = $this->query_with_filter();
        } else {
            $query = $this->query_without_filter();
        }

        $status = '200 - OK';
        $message = 'Success';
        $sql = $query->query;
        $results = $query->results;
        $affected_rows = $query->affected_rows;


        return $this->_result($status, $message, $sql, $results, $affected_rows, null);
    }

    public function get_contacts_by_id(int $id) {

        $query = null;
        $this->_contact_id = $id;

        $query = $this->query_with_filter();

        $status = '200 - OK';
        $message = 'Success';
        $sql = $query->query;
        $results = $query->results;
        $affected_rows = $query->affected_rows;


        return $this->_result($status, $message, $sql, $results, $affected_rows, null);
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
