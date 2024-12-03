<?php  
class Expense extends Base {
    function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Returns total expense amount within n days from now
    public function Expenses($UserID, $n) {
        $stmt = $this->pdo->prepare("SELECT SUM(Cost) AS TOTAL FROM expense WHERE UserID = :UserID AND DATE(`Date`) BETWEEN CURDATE() - INTERVAL :n DAY AND CURDATE()");
        $stmt->bindParam(":UserID", $UserID, PDO::PARAM_INT);
        $stmt->bindParam(":n", $n, PDO::PARAM_INT);
        $stmt->execute();
        $today = $stmt->fetch(PDO::FETCH_OBJ);
        return $today ? $today->TOTAL : NULL;
    }

    // Returns yesterday's expense amount
    public function Yesterday_expenses($UserID) {
        $stmt = $this->pdo->prepare("SELECT SUM(Cost) AS TOTAL FROM expense WHERE UserID = :UserID AND DATE(`Date`) = CURDATE() - INTERVAL 1 DAY");
        $stmt->bindParam(":UserID", $UserID, PDO::PARAM_INT);
        $stmt->execute();
        $yest = $stmt->fetch(PDO::FETCH_OBJ);
        return $yest ? $yest->TOTAL : NULL;
    }

    // Returns total expense amount till date
    public function totalexp($UserID) {
        $stmt = $this->pdo->prepare("SELECT SUM(Cost) AS TOTAL FROM expense WHERE UserID = :UserID AND DATE(`Date`) <= CURDATE()");
        $stmt->bindParam(":UserID", $UserID, PDO::PARAM_INT);
        $stmt->execute();
        $total = $stmt->fetch(PDO::FETCH_OBJ);
        return $total ? $total->TOTAL : NULL;
    }

    // Expenses of Current Month(Datewise)
    public function Current_month_expenses($UserID) {
        $stmt = $this->pdo->prepare("SELECT SUM(Cost) AS exp1 FROM expense WHERE UserID = :UserID AND MONTH(Date) = MONTH(CURRENT_DATE()) AND YEAR(Date) = YEAR(CURRENT_DATE()) AND DATE(`Date`) <= CURDATE()");
        $stmt->bindParam(":UserID", $UserID, PDO::PARAM_INT);
        $stmt->execute();
        $rows2 = $stmt->fetch(PDO::FETCH_OBJ);
        return $rows2 ? $rows2->exp1 : NULL;
    }

    // Returns expense records between 2 given dates
    public function dtwise($UserID, $FROM, $TO) {
        $stmt = $this->pdo->prepare("SELECT * FROM expense WHERE DATE(`Date`) BETWEEN :fromdate AND :todate AND UserID = :user ORDER BY Date");
        $stmt->bindParam(":user", $UserID, PDO::PARAM_INT);
        $stmt->bindParam(":fromdate", $FROM, PDO::PARAM_STR); 
        $stmt->bindParam(":todate", $TO, PDO::PARAM_STR);
        $stmt->execute();
        $dt = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $dt ? $dt : NULL;
    }

    // Returns expense records between any two given months
    public function mthwise($UserID, $FROM, $TO) {
      $stmt = $this->pdo->prepare("SELECT * FROM expense WHERE DATE(`Date`) BETWEEN :fromdate AND LAST_DAY(:todate) AND UserID = :user ORDER BY Date");
      $stmt->bindParam(":user", $UserID, PDO::PARAM_INT);
      $stmt->bindParam(":fromdate", $FROM, PDO::PARAM_STR); 
      $stmt->bindParam(":todate", $TO, PDO::PARAM_STR);
      $stmt->execute();
      $rows = $stmt->fetchAll(PDO::FETCH_OBJ);
      return $rows ? $rows : NULL;
  }
  

    // Returns expense records(rows) between any two given years
    public function yrwise($UserID, $FROM, $TO) {
        $stmt = $this->pdo->prepare("SELECT * FROM expense WHERE EXTRACT(year FROM Date) BETWEEN :fromdate AND :todate AND DATE(`Date`) <= CURDATE() AND UserID = :user ORDER BY Date");
        $stmt->bindParam(":user", $UserID, PDO::PARAM_INT);
        $stmt->bindParam(":fromdate", $FROM, PDO::PARAM_STR); 
        $stmt->bindParam(":todate", $TO, PDO::PARAM_STR);
        $stmt->execute();
        $dt = $stmt->fetchAll(PDO::FETCH_OBJ);
        return $dt ? $dt : NULL;
    }

    // Returns all rows from expense table with category names
// Returns all rows from expense table with category names, ordered by date from newest to oldest
public function allexp($UserID) {
    $stmt = $this->pdo->prepare("
        SELECT e.*, c.CategoryName 
        FROM expense e 
        LEFT JOIN category c ON e.CategoryID = c.CategoryID 
        WHERE e.UserID = :UserID 
        ORDER BY e.Date DESC
    ");
    $stmt->bindParam(":UserID", $UserID, PDO::PARAM_INT);
    $stmt->execute();
    $total = $stmt->fetchAll(PDO::FETCH_OBJ);
    return $total ? $total : NULL;
}


    // Returns a particular expense record(with given expense id)
    public function delexp($ExpenseID) {
        $stmt = $this->pdo->prepare("DELETE FROM expense WHERE ExpenseID = :id");
        $stmt->bindParam(":id", $ExpenseID, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getRecentExpenses($userID) {
        $sql = "SELECT e.*, c.CategoryName 
                FROM expense e 
                LEFT JOIN category c ON e.CategoryID = c.CategoryID 
                WHERE e.UserID = :userID 
                ORDER BY e.Date DESC 
                LIMIT 10";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['userID' => $userID]);
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }



    // Method to search expenses
// Method to search expenses
public function searchExpenses($userID, $keyword, $category) {
    $sql = "SELECT e.*, c.CategoryName 
            FROM expense e 
            LEFT JOIN category c ON e.CategoryID = c.CategoryID 
            WHERE e.UserID = :userID ";

    $parameters = ['userID' => $userID];

    // Add conditions to the query based on the provided search parameters
    if (!empty($keyword)) {
        $sql .= "AND (e.Item LIKE :keyword OR c.CategoryName LIKE :keyword) ";
        $parameters['keyword'] = "%$keyword%";
    }

    if (!empty($category)) {
        $sql .= "AND c.CategoryName LIKE :category ";
        $parameters['category'] = "%$category%";
    }

    // Order the search results by date in descending order (newest to oldest)
    $sql .= "ORDER BY e.Date DESC";

    $stmt = $this->pdo->prepare($sql);
    $stmt->execute($parameters);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}



    public function getExpensesByCategory($userID, $categoryID) {
        $stmt = $this->pdo->prepare("SELECT * FROM expense WHERE UserID = :userID AND CategoryID = :categoryID ORDER BY Date");
        $stmt->bindParam(":userID", $userID, PDO::PARAM_INT);
        $stmt->bindParam(":categoryID", $categoryID, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
