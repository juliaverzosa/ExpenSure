<?php 
    include_once "init.php";

    //User login check
    if ($getFromU->loggedIn() === false) {
        header('Location: index.php');
    }

    if (isset($_SESSION['swal'])) {
        echo $_SESSION['swal'];
        unset($_SESSION['swal']);
    }

    // Budget validity checker 
    $budget_validity = $getFromB->budget_validity_checker($_SESSION['UserID']);
    if ($budget_validity == false) {
        $getFromB->del_budget_record($_SESSION['UserID']);
    }

    // Today's Expenses
    $today_expense = $getFromE->Expenses($_SESSION['UserID'], 0);
    if ($today_expense == NULL) {
        $today_expense = "No Expenses Logged Today";
    } else {
        $today_expense = "₱ " . number_format($today_expense, 2);
    }

    // Yesterday's Expenses
    $Yesterday_expense = $getFromE->Yesterday_expenses($_SESSION['UserID']);
    if ($Yesterday_expense == NULL) {
        $Yesterday_expense = "No Expenses Logged Yesterday";
    } else {
        $Yesterday_expense = "₱ " . number_format($Yesterday_expense, 2);
    }

    // Last 7 Days' Expenses 
    $week_expense = $getFromE->Expenses($_SESSION['UserID'], 6);
    if ($week_expense == NULL) {
        $week_expense = "No Expenses Logged This Week";
    } else {
        $week_expense = "₱ " . number_format($week_expense, 2);
    }

    // Last 30 Days' Expenses
    $monthly_expense = $getFromE->Expenses($_SESSION['UserID'], 29);
    if ($monthly_expense == NULL) {
        $monthly_expense = "No Expenses This Month";
    } else {
        $monthly_expense = "₱ " . number_format($monthly_expense, 2);
    }

    // Total Expenses
    $total_expenses = $getFromE->totalexp($_SESSION['UserID']);
    if ($total_expenses == NULL) {
        $total_expenses = "No Expenses Logged Yet";
    } else {
        $total_expenses = "₱ " . number_format($total_expenses, 2);
    }

    // Budget Left for the month
    $budget_left = $getFromB->checkbudget($_SESSION['UserID']);
    if ($budget_left == NULL) {
        $budget_left = "Not Set Yet";
    } else {
        $currmonexp = $getFromE->Current_month_expenses($_SESSION['UserID']);
        if ($currmonexp == NULL) {
            $currmonexp = 0;
        }
        $budget_left = $budget_left - $currmonexp;
        $budget_left = "₱ " . number_format($budget_left, 2);
    }

    $expense = new Expense($pdo);
    $recentExpenses = $expense->allexp($_SESSION['UserID']);
    $recentExpenses = $getFromE->getRecentExpenses($_SESSION['UserID']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="main.css">
    <title>ExpenSure : Your Expense Manager</title>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-wink-smile'></i>
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
                    <h1>Dashboard</h1>
                </div>
            </div>

            <!-- Insights -->
            <ul class="insights">
                <li>
                    <i class='bx bxs-wallet'></i>
                    <span class="text">
                        <h3><?php echo $budget_left ?></h3>
                        <p>Monthly Budget</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-calendar-check'></i>
                    <span class="text">
                        <h3><?php echo $today_expense ?></h3>
                        <p>Today's Expenses</p>
                    </span>
                </li>
                <li>
                    <i class='bx bx-rotate-left'></i>
                    <span class="text">
                        <h3><?php echo $Yesterday_expense ?></h3>
                        <p>Yesterday's Expenses</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-calendar-week'></i>
                    <span class="text">
                        <h3><?php echo $week_expense ?></h3>
                        <p>Last 7 Day's Expenses</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-calendar'></i>
                    <span class="text">
                        <h3><?php echo $monthly_expense ?></h3>
                        <p>Last 30 Day's Expenses</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-dollar-circle'></i>
                    <span class="text">
                        <h3><?php echo $total_expenses ?></h3>
                        <p>Total Expenses</p>
                    </span>
                </li>
            </ul>
            <!-- End of Insights -->

            <div class="bottom-data">
                <div class="orders">
                    <div class="header">
                        <i class='bx bx-receipt'></i>
                        <h3>Recent Expenses</h3>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Cost</th>
                                <th>Category</th>
                                <th>Date</th>
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
                                    echo "<td>{$expense->CategoryName}</td>"; // Display category name
                                    echo "<td>{$expense->Date}</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>No recent expenses found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- View All Button -->
                    <div class="view-all">
                        <a href="manage-expenses.php" class="btn">View All</a>
                    </div>
                </div>

      
            </div>
        </main>
    </div>

    <script src="index.js"></script>
    <script></script>
</body>

</html>
