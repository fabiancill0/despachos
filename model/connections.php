<?php

class Connections
{
  private $dbServ = "SuizaSoftDesarrollo";
  private $username = "fcarrasco";
  private $pass = "fcarrasco";

  public function __construct() {}

  public function connectTo($conn)
  {
    $connection = odbc_connect($conn, $this->username, $this->pass);
    return $connection;
  }

  public function connectToServ()
  {
    $connection = odbc_connect($this->dbServ, $this->username, $this->pass);
    return $connection;
  }
}
