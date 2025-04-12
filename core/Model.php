<?php
class Model extends Database
{
  public $conn;
  public $table;
  public function __construct()
  {
    $this->conn = $this->getConnect();
  }
  public function select($columns = "*", $conditional = null, $param = [])
  {
    $sql = "SELECT $columns FROM {$this->table}";
    if ($conditional) {
      $sql .= " WHERE $conditional";
    }
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($param);
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $list;
  }
  public function selectOne($columns = "*", $conditional = null, $param = [])
  {

    $sql = "SELECT $columns FROM {$this->table}";
    if ($conditional) {
      $sql .= " WHERE $conditional";
    }
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($param);
    $list = $stmt->fetch(PDO::FETCH_ASSOC);
    return $list;
  }
  public function dividePage($page = 1, $limit = 5, $columns = "*", $conditional = null, $param = [])
  {
    $sql = "SELECT $columns FROM {$this->table}";
    if ($conditional) {
      $sql .= " WHERE $conditional";
    }
    // var_dump($page);
    $offset = ($page - 1) * $limit;
    $sql .= " LIMIT $limit OFFSET $offset";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($param);
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $list;
  }
  public function find($columns = "*", $conditional = null, $param = [],$table=null){
    $sql = "SELECT $columns FROM $table";
    if ($conditional) {
      $sql .= " WHERE $conditional";
    }
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($param);
    $list = $stmt->fetch(PDO::FETCH_ASSOC);
    return $list;
  }

  public function delete($conditional = null, $param = [])
  {
    $sql = "DELETE FROM {$this->table}";
    if ($conditional) {
      $sql .= " WHERE $conditional";
    }
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($param);
    return $stmt->rowCount();
  }
  public function delete2($table = null, $conditional = null, $param = [])
  {
    $sql = "DELETE FROM $table";
    if ($conditional) {
      $sql .= " WHERE $conditional";
    }
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($param);
    return $stmt->rowCount();
  }

  public function changeStatus($status, $conditional = null, $param = [])
  {
    $newStatus = $status == 1 ? 0 : 1;
    $sql = "UPDATE {$this->table} set status = $newStatus";
    if ($conditional) {
      $sql .= " WHERE $conditional";
    }
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($param);
    return $stmt->rowCount();
  }


  public function insert($data = [])
  {
    $columns = implode(',', array_keys($data));
    // name, email
    $placeholders = ':' . implode(', :', array_keys($data));
    // :name, :email
    $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($data);
    return $this->conn->lastInsertId();
  }
  public function insert2($data = [], $table = null)
  {
    var_dump($data);
    $columns = implode(',', array_keys($data));
    // name, email
    $placeholders = ':' . implode(', :', array_keys($data));
    // :name, :email
    $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($data);
    return $this->conn->lastInsertId();
  }

  public function update($data = [], $conditional = null, $param = [])
  {
    $columns = array_keys($data);
    $plusSet = array_map(function ($column) {
      return "$column = :set_$column";
    }, $columns);
    // name = :name, email = :email
    $set = implode(', ', $plusSet);
    // echo $set;
    $sql = "UPDATE {$this->table} SET $set";
    if ($conditional) {
      $sql .= " WHERE $conditional";
    }
    $stmt = $this->conn->prepare($sql);
    foreach ($data as $key => &$value) {
      $stmt->bindParam(":set_$key", $value);
    }
    foreach ($param as $key => &$value) {
      $stmt->bindParam(":$key", $value);
    }
    $stmt->execute();
    return $stmt->rowCount();
  }
  public function selectAll($sql, $param = [])
  {
    $stmt = $this->conn->prepare($sql);
    $stmt->execute($param);
    $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $list;
  }
}
