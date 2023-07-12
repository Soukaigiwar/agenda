<?php

namespace sql_connection;

use stdClass;
use sql_connection\Database;

require_once('env/constants.php');
require_once('./Database.php');

class Contact {
    private string $_search = '';
    private string $_id = '';

    private function query_with_filter() {
        
        $db = new Database(MYSQL_CONFIG);
        
        if($this->_search != null){

            if (is_numeric($this->_search)) {
                $params = [':search' => '%' . trim($this->_search) . '%'] ;
                $query = $db->execute_query("SELECT * FROM telefones
                    WHERE telefone LIKE :search
                    ORDER BY created_at DESC", $params);
            } else {
                $params = [':search' => '%' . trim($this->_search) . '%'];
                $query = $db->execute_query("SELECT * FROM telefones
                    WHERE nome LIKE :search OR telefone LIKE :search
                    ORDER BY created_at DESC", $params);
            }
        }

        if($this->_id) {
            $params = [':id' => $this->_id];
            $query = $db->execute_query("SELECT * FROM telefones WHERE id = :id", $params);
            return $query;
        }

        return $query;
    }

    private function query_without_filter() {

        $db = new Database(MYSQL_CONFIG);
        $query = $db->execute_query("SELECT * FROM telefones ORDER BY created_at DESC");
        
        return $query;
    }

    public function get_contacts(string $search = '') {

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

    public function get_contacts_by_id(string $id) {

        $query = null;
        $this->_id = $id;

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