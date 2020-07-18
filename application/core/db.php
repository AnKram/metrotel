<?php

class DB {

    private static $instance;
    private $db_conn;

    private function __construct() {}

    /**
     *
     * @return DB
     */
    private static function getInstance(){
        if (self::$instance == null){
            $className = __CLASS__;
            self::$instance = new $className;
        }

        return self::$instance;
    }

    /**
     *
     * @return DB
     */
    private static function initConnection(){
        $db = self::getInstance();
        $conn_conf = getConfigData();
        $db->db_conn = new PDO('mysql:host=' . $conn_conf['db_host'] . ';dbname=' . $conn_conf['db_name'], $conn_conf['db_user'], $conn_conf['db_pass']);
        $db->db_conn->exec("set names utf8");
        return $db;
    }

    /**
     * @return mysqli
     */
    public static function getDbConn() {
        try {
            $db = self::initConnection();
            return $db->db_conn;
        } catch (Exception $ex) {
            echo 'Connection error. ' . $ex->getMessage();
            return null;
        }
    }
}