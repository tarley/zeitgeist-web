<?php

class DBContext
{
    protected $conn;

    function __construct()
    {
        $this->startConnection();
    }

    public function startConnection() {
        try {
            $options = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
                //PDO::ATTR_PERSISTENT => TRUE
            );

			$this->conn = new PDO("mysql:host=" . SERVERNAME . ";dbname=" . DBNAME . ";charset=utf8;", USERNAME, PASSWORD, $options);
			$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//$this->conn->exec("set names utf8");
        } catch (PDOException $e) {
			$this->conn = null;
            Log::Error($e->getMessage());
        }
    }

    public function getConnection()
    {
        if ($this->conn == null) {
            $this->startConnection();
        }

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