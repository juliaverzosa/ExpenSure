<?php include_once "init.php"; ?>

<?php 
    // User login checker
    if ($getFromU->loggedIn() === false) {
        header('Location:index.php');
    }

    $expense = new Expense($pdo);
    $searchResults = [];
    $searchKeyword = '';
    $orderBy = '';

    // Handle search and filtering
    if (isset($_POST['search'])) {
        $searchKeyword = isset($_POST['keyword']) ? $_POST['keyword'] : '';
        $searchCategory = isset($_POST['category']) ? $_POST['category'] : '';

        $searchResults = $expense->searchExpenses($_SESSION['UserID'], $searchKeyword, $searchCategory);
    }
?>


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
                    <h1>Search Expenses</h1>
                    <ul class="breadcrumb">
						<li>
							<a class="active" href="manage-expenses.php">All Expenses</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a href="#">Search</a>
						</li>
					</ul>
                </div>
            </div>
            <form action="search-expense.php" method="post">
                <div class="form-input">
                    <input type="search" name="keyword" placeholder="Search..." value="<?php echo $searchKeyword; ?>">
                    <button class="search-btn" type="submit" name="search"><i class='bx bx-search'></i></button>
                </div>
                <!-- <div class="filter-options">
                    <label for="orderby">Order by:</label>
                    <select name="orderby" id="orderby">
                        <option value="" disabled selected>Select order</option>
                        <option value="date_asc" <?php if ($orderBy == 'date_asc') echo 'selected'; ?>>Date Ascending</option>
                        <option value="date_desc" <?php if ($orderBy == 'date_desc') echo 'selected'; ?>>Date Descending</option>
                        <option value="name_asc" <?php if ($orderBy == 'name_asc') echo 'selected'; ?>>Name Ascending</option>
                        <option value="name_desc" <?php if ($orderBy == 'name_desc') echo 'selected'; ?>>Name Descending</option>
                        <option value="category" <?php if ($orderBy == 'category') echo 'selected'; ?>>Category</option>
                    </select>
                    <button type="submit" name="search">Filter</button>
                </div> -->
            </form>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <i class='bx bx-receipt'></i>
                        <h3>Search Results</h3>
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
                            // Display search results
                            if (!empty($searchResults)) {
                                foreach ($searchResults as $expense) {
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
                                echo "<tr><td colspan='5'>No matching expenses found.</td></tr>";
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
    </div>
</body>
