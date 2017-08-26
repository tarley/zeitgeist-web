<?php

class BaseRepository
{
    protected $db;

    function __construct()
    {
        $this->db = new DBContext();
    }

    function __destruct()
    {
        $this->db->close();
    }
}