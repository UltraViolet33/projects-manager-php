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
   * read
   * read on the BDD"
   * @return array
   */
  public function read($query, $data = array(), $single = false)
  {
    $statement = $this->PDOInstance->prepare($query);
    $result = $statement->execute($data);

    if ($result) {
      if ($single) {
        $data = $statement->fetch(PDO::FETCH_OBJ);
        return $data;
      } else {
        $data = $statement->fetchAll(PDO::FETCH_OBJ);
      }
      if (is_array($data) && count($data) > 0) {
        return $data;
      }
    }
    return false;
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
