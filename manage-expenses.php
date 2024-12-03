<?php include_once "init.php"; 
// User login checker
if ($getFromU->loggedIn() === false) {
    header('Location:index.php');
}

// Deletes expense record
if (isset($_POST['delrec'])) {
    $getFromE->delexp($_POST['delrec']); // Assuming 'delrec' contains the ID of the expense to be deleted
    echo "<script>
            Swal.fire({
                title: 'Done!',
                text: 'Record deleted successfully',
                icon: 'success',
                confirmButtonText: 'Close'
            })
          </script>";
}

// Update expense record
if (isset($_POST['updrec'])) {
    $dt = date("Y-m-d", strtotime($_POST["dateexpense"]));
    $itemname = $_POST['item'];
    $itemcost = $_POST['costitem'];
    $categoryID = $_POST['category']; // Capture the category ID
    $expense_id = $_POST['updrec']; // Assuming 'updrec' contains the ID of the expense to be updated



    
    // Validate date (no future date allowed)
    $currentDate = date("Y-m-d");
    if ($dt > $currentDate) {
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Date cannot be in the future.',
                    icon: 'error',
                    confirmButtonText: 'Close'
                })
              </script>";
    } else if (!is_numeric($itemcost) || $itemcost <= 0) {
        // Validate cost (must be a positive number)
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Cost must be a positive number.',
                    icon: 'error',
                    confirmButtonText: 'Close'
                })
              </script>";
    } else {
        $fields = array(
            'Item' => $itemname,
            'Cost' => $itemcost,
            'Date' => $dt,
            'CategoryID' => $categoryID // Add CategoryID to the fields array
        );

        $getFromE->update("expense", $expense_id, $fields);

        echo "<script>
                Swal.fire({
                    title: 'Done!',
                    text: 'Record updated successfully',
                    icon: 'success',
                    confirmButtonText: 'Close'
                })
              </script>";
    }
}

$expense = new Expense($pdo);
$recentExpenses = $expense->allexp($_SESSION['UserID']); // Fetch all expenses for the current user



?>
<!-- Rest of your HTML -->


<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="manage-expenses.css">
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-smile'></i>
            <div class="logo-name"><span>Expen</span>Sure</div>
        </a>
        <ul class="side-menu">
            <li><a href="dashboard.php"><i class='bx bxs-dashboard'></i>Dashboard</a></li>
            <li><a href="set-budget.php"><i class='bx bxs-wallet-alt'></i>Budget</a></li>
            <li><a href="add-expenses.php"><i class='bx bx-add-to-queue'></i>Add Expense</a></li>
            <li><a href="manage-expenses.php"><i class='bx bx-edit'></i>Manage Expenses</a></li>
            <!-- <li><a href="report.php"><i class='bx bxs-report'></i>Report</a></li> -->
        </ul>
        <ul class="side-menu">
            <li>
                <a href="logout.php" class="logout">
                    <i class='bx bx-log-out-circle'></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
    <!-- End of Sidebar -->

    <!-- Main Content -->
    <div class="content">
        <!-- Navbar -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="profile.php" class="profile">
                <img src="user.png">
            </a>
        </nav>
        <!-- End of Navbar -->

        <main>
        <div class="header">
                <div class="left">
                    <h1>Manage Expenses</h1>

                 </div>
                <div class="view-all">
                        <a href="search-expense.php" class="btn">Search</a>
                    </div>
                    <!-- <div class="view-all">
                        <a href="manage-expenses.php" class="btn">View All</a>
                    </div>
                    <div class="view-all">
                        <a href="manage-expenses.php" class="btn">View All</a>
                    </div>
                    <div class="view-all">
                        <a href="manage-expenses.php" class="btn">View All</a>
                    </div>  -->
                <!-- <a href="search-expense.php" class="search">
                    <i class='bx bx-search'></i>
                    <span>Search</span>
                </a> -->
            </div>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                    <i class='bx bx-receipt'></i>
                        <h3>All Expenses</h3>
                        <!-- Search input and button removed -->
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Cost</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Display recent expenses
                            if (!empty($recentExpenses)) {
                                foreach ($recentExpenses as $expense) {
                                    echo "<tr>";
                                    echo "<td>{$expense->Item}</td>";
                                    echo "<td>₱{$expense->Cost}</td>";
                                    echo "<td>{$expense->CategoryName}</td>";
                                    echo "<td>{$expense->Date}</td>";
                                    echo "<td>
                                            <i class='edit-icon bx bx-edit' data-id='{$expense->ExpenseID}'></i>
                                            <i class='delete-icon bx bx-trash-alt' data-id='{$expense->ExpenseID}'></i>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No recent expenses found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>

        <!-- Edit Expense Form (Initially Hidden) -->
        <div class="edit-expense-form" id="edit-expense-form" style="display: none;">
        <form id="expense-edit-form" method="post">
            <input type="hidden" id="updrec" name="updrec">
            <label for="item">Item:</label>
            <input type="text" id="item" name="item" required>
            <label for="costitem">Cost:</label>
            <input type="text" id="costitem" name="costitem" required>
            <label for="dateexpense">Date:</label>
            <input type="datetime-local" id="dateexpense" name="dateexpense" required>
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <?php
                $categories = $getFromC->getAll(); // Assume $getFromC is the object to get categories
                foreach ($categories as $category) {
                    echo "<option value='{$category->CategoryID}'>{$category->CategoryName}</option>";
                }
                ?>
            </select>
            <button type="submit">Update</button>
        </form>
        </div>

        <script src="index.js"></script>
        <script src="manage-expenses.js"></script>
        <script>
    function validate(event) {
        // Allow numbers only
        const charCode = (event.which) ? event.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            event.preventDefault();
        }
    }

    function validateCost(input) {
        // Disallow negative values
        if (input.value < 0) {
            input.value = '';
        }
    }
    
</script>
    </div>
</body>
