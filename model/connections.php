<?php

class Connections
{
  private $dbServ = "ProdServFtgo_2024";
  private $dbRK = "ProdFrutango_2024";
  private $dbEst = "EstFrutango";
  private $dbAppBase = "AppBase";
  private $dbCasino = "ConexionCasino";
  private $dbVal = "frt_validacion_sis";
  private $dbQC = "frt_qc";
  private $username = "lmendez";
  private $pass = "ADAMARCELA";

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
  public function connectToRK()
  {
    $connection = odbc_connect($this->dbRK, $this->username, $this->pass);
    return $connection;
  }
  public function connectToEst()
  {
    $connection = odbc_connect($this->dbEst, $this->username, $this->pass);
    return $connection;
  }
  public function connectToAB()
  {
    $connection = odbc_connect($this->dbAppBase, '', '');
    return $connection;
  }
  public function connectToCasino()
  {
    $connection = odbc_connect($this->dbCasino, '', '');
    return $connection;
  }
  public function connectToVal()
  {
    $connection = mysqli_connect(null, null, null, $this->dbVal, null, null);
    return $connection;
  }
  public function connectToQC()
  {
    $connection = mysqli_connect(null, null, null, $this->dbQC, null, null);
    return $connection;
  }
}
