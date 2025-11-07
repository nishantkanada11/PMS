<?php
class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = '';
    private $dbname = 'pms';

    public $con;

    public function getConnection()
    {
        if ($this->con === null) {
            $this->con = new mysqli($this->host, $this->user, $this->password, $this->dbname);
            if ($this->con->connect_error) {
                die("connetion failed" . $this->con->connect_error);
            }
        }
        return $this->con;
    }
}