<?php
class Model
{
    /**
     * @var mysqli
     */
    protected $db_conn;

    public function __construct()
    {
        $this->db_conn = DB::getDbConn();
    }

    public function getDbConn()
    {
        return $this->db_conn;
    }
}