<?php

require_once "./core/connection/config.php";

class Database
{

  private $PDOInstance = null;

  public function __construct()
  {
    $string = DB_TYPE . ":host=" . DB_HOST . ";dbname=" . DB_NAME;
    $this->PDOInstance  = new PDO($string, DB_USER, DB_PASS);
  }


  /**
   * readSingleRow
   *
   * @param  string $query
   * @param  array $data
   * @return array
   */
  public function readSingleRow(string $query, array $data): array
  {
    $statement = $this->PDOInstance->prepare($query);
    $statement->execute($data);
    $result =  $statement->fetch(PDO::FETCH_ASSOC);

    return $result ? $result : [];
  }


  
  /**
   * readMultipleRows
   *
   * @param  string $query
   * @param  array $data
   * @return array
   */
  public function readMultipleRows(string $query, array $data = array()): array
  {
    $statement = $this->PDOInstance->prepare($query);
    $statement->execute($data);
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $result ? $result : [];
  }
  

  /**
   * write
   * write on the BDD
   * @return bool
   */
  public function write($query, $data = array())
  {
    $statement = $this->PDOInstance->prepare($query);
    return $statement->execute($data);
  }

  /**
   * getLastInsertId
   * return the last id inserted
   * @return void
   */
  public function getLastInsertId()
  {
    return $this->PDOInstance->lastInsertId();
  }
}
