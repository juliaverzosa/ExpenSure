<?php 
include_once "init.php";
if ($getFromU->loggedIn() === false) {
    header('Location: index.php');
    exit();
}

$successMessage = ""; // Initialize success message variable

if (isset($_POST['enterbudget'])) {
    $user_id = $_SESSION['UserID'];
    $budget = $_POST['budget'];

    // Server-side validation
    if (!ctype_digit($budget) || intval($budget) <= 0) {
        $errorMessage = "Please enter a valid budget (positive numbers only).";
    } else {
        $successMessage = "Budget updated successfully"; // Update success message variable
    
        $curr_budget = $getFromB->checkbudget($user_id);

        if ($curr_budget == NULL) {
            $getFromB->setbudget($user_id, $budget);
        } else {
            $getFromB->updatebudget($user_id, $budget);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Budget</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="set-budget.css">
</head>
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
        <!-- Budget form -->
        <main>
            <div class="header">
                <div class="left">
                    <h1>Set Budget</h1>
                    <p>The monthly budget will automatically reset after a month.</p>
                </div>
            </div>
            <div class="budget-form">
    <div class="card">
        <div class="card-header">Enter your budget for this month:</div>
        <div class="card-body">
            <?php if (!empty($successMessage)) : ?>
                <div style="color: green;"><?php echo $successMessage; ?></div>
            <?php endif; ?>
            <form action="" method="post" id="budgetForm"> 
                <input type='text' name="budget" class="text-input" placeholder="Enter your budget" required/>
                <div id="error-message" style="color: red;"></div>
                <button type="submit" name="enterbudget" class="pressbutton">Submit</button>
            </form>
        </div>
    </div>
</div>
        </main>
        <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            var budgetInput = document.querySelector('input[name="budget"]').value;
            var errorMessageDiv = document.getElementById('error-message');

            if (!/^\d+$/.test(budgetInput) || parseInt(budgetInput) <= 0) {
                event.preventDefault();
                errorMessageDiv.textContent = "Please enter a valid budget (positive numbers only).";
            } else {
                errorMessageDiv.textContent = "";
            }
        });
    </script>
    <script src="index.js"></script>
    </div>


</body>
</html>
