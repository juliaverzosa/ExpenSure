<!-- base.php -->
<?php 
  class Base {
    protected $pdo;
    
    function __construct($pdo) {
      $this->pdo = $pdo;
    }
 
    public function create($table, $fields = array()) {
      $columns = implode(',', array_keys($fields));
      $values = ':' . implode(', :', array_keys($fields));
      $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$values})";
      if ($stmt = $this->pdo->prepare($sql)) {
        foreach ($fields as $key => $data) {
          $stmt->bindValue(':'.$key, $data);
        }
        $stmt->execute();
        return $this->pdo->lastInsertId();
      }
    }
 
    public function update($table, $expense_id, $fields = array()) {
      $columns = '';
      $i = 1;
      foreach ($fields as $name => $value) {
          $columns .= "{$name} = :{$name}";
          if ($i < count($fields)) {
              $columns .= ", ";
          }
          $i++;
      }
      $sql = "UPDATE {$table} SET {$columns} WHERE ExpenseID = :expense_id";
      if ($stmt = $this->pdo->prepare($sql)) {
          $stmt->bindValue(':expense_id', $expense_id);
          foreach ($fields as $key => $value) {
              $stmt->bindValue(':' . $key, $value);
          }
          $stmt->execute();
          // Optionally, you might want to return true or false indicating the success of the update operation
          return true;
      } else {
          // Optionally, you might handle any potential errors here
          return false;
      }
  }
  
  public function search($table, $columns, $keyword, $userId) {
    $sql = "SELECT * FROM {$table} WHERE UserID = :userId AND (";
    $columnCount = count($columns);
    for ($i = 0; $i < $columnCount; $i++) {
        $sql .= "{$columns[$i]} LIKE :keyword";
        if ($i < $columnCount - 1) {
            $sql .= " OR ";
        }
    }
    $sql .= ")";
    if ($stmt = $this->pdo->prepare($sql)) {
        $stmt->bindValue(':keyword', '%' . $keyword . '%');
        $stmt->bindValue(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    return [];
}

 
    public function delete($table, $array) {
      $sql = "DELETE FROM {$table}";
      $where = " WHERE";
 
      foreach ($array as $name => $value) {
        $sql .= "{$where} {$name} = :{$name}";
        $where = " AND ";
      }
 
      if ($stmt = $this->pdo->prepare($sql)) {
        foreach ($array as $name => $value) {
          $stmt->bindValue(':'.$name, $value);
        }
      }
      $stmt->execute();
    }
  }
 
?>