<?php

class DBContext
{
    protected $conn;

    function __construct()
    {
        try {
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                PDO::ATTR_PERSISTENT => TRUE
            );

            $c = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DBNAME . ";charset=utf8;", USERNAME, PASSWORD, $options);
            $c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn = $c;
        } catch (PDOException $e) {
            $conn = NULL;
            CreateLog($e->getMessage());
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }

    public function query($sql)
    {
        return $this->conn->query($sql);
    }

    public function close()
    {
        $this->conn = null;
    }
}