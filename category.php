<?php  
  class Category extends Base {
    function __construct($pdo) {
      $this->pdo = $pdo;
    }

    
        // Method to get all categories
        public function getAll() {
            $stmt = $this->pdo->prepare("SELECT * FROM category");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }