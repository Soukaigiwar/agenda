<?php

namespace sql_connection;

use PDO;
use PDOException;
use stdClass;

class Database {

    private string $_host;
    private string $_database;
    private string $_username;
    private string $_password;
    private string $_return_type;
    
    public function __construct(array $options, string $return_type = 'object'){
        $this->_host = $options['host'];
        $this->_database = $options['database'];
        $this->_username = $options['username'];
        $this->_password = $options['password'];

        (!empty($return_type) && $return_type == 'object') ?
                $this->_return_type = PDO::FETCH_OBJ :
                $this->_return_type = PDO::FETCH_ASSOC;
    }

    public function execute_query($sql, $params = null){
        $connection = new PDO(
            'mysql:host=' . $this->_host .
            ';dbname=' . $this->_database . 
            ';charset=utf8',
            $this->_username,
            $this->_password,
            array(PDO::ATTR_PERSISTENT => true)
        );

        $results = null;

        try {
            $db = $connection->prepare($sql);
            
            (!empty($params)) ? 
                $db->execute($params) : 
                $db->execute();

            $results = $db->fetchAll($this->_return_type);

        } catch (PDOException $err) {
            $connection = null;
            return $this->_result('error', $err->getMessage(), $sql, null, 0, null);
        }

        $connection = null;
        return $this->_result('success', '', $sql, $results, $db->rowCount(), null);
    }

    public function execute_non_query($sql, $params = null){
        $connection = new PDO(
            'mysql:host=' . $this->_host .
            ';dbname=' . $this->_database . 
            ';charset=utf8',
            $this->_username,
            $this->_password,
            array(PDO::ATTR_PERSISTENT => true)
        );

        $connection->beginTransaction();

        try {
            $db = $connection->prepare($sql);

            (!empty($params)) ? 
                $db->execute($params) : 
                $db->execute();
            
            $last_inserted_id = $connection->lastInsertId();

            $connection->commit();
        } catch (PDOException $e) {

            $connection->rollBack();
            
            $connection = null;
            return $this->_result('error', $e->getMessage(), $sql, null, 0, null);
        }

        $connection = null;
        return $this->_result('success', '', $sql, null, $db->rowCount(), $last_inserted_id);
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