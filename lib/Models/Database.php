<?php
/**
 * Name: Class Database
 * Purpose: To connect with any mysql databases.
 * Comment:
 * 
 * Editor: Jason Lai
 * Edit Time: 2018/12/13
 * Update Time: 2018/12/13
 */
class Database
{
    protected $DB_HOST;
    protected $DB_USER;
    protected $DB_PASS;
    protected $DB_NAME;
    protected $conn;

    function __construct(){
        $this->conn = new mysqli($this->DB_HOST, $this->DB_USER, $this->DB_PASS, $this->DB_NAME);
        if($this->conn->connect_error)
            die("Connection error: " . $this->conn->connect_error);
        $this->conn->set_charset("utf8");
    }

    function __desctruct(){
        $this->conn->close();
    }
}
?>