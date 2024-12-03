
<?php 
include_once "init.php";

// User login checker
if ($getFromU->loggedIn() === false) {
    header('Location:index.php');
}

// Get current month's expenses
$currentMonth = date('Y-m');
$expenses = $getFromE->mthwise($_SESSION['UserID'], $currentMonth, $currentMonth);

// Prepare data for the chart
// Check Expense Data Preparation
$daysInMonth = date('t', strtotime($currentMonth)); // Number of days in the month
$expenseData = array_fill(1, $daysInMonth, 0); // Initialize expense data for each day

if (!empty($expenses)) {
    foreach ($expenses as $exp) {
        $day = date('j', strtotime($exp->Date));
        $expenseData[$day] += $exp->Cost;
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Expense Report</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="manage-expenses.css">
    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <li><a href="report.php"><i class='bx bxs-report'></i>Report</a></li>
       
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
                    <h1>Expense Report for <?php echo date('F Y'); ?></h1>
                </div>
            </div>
            
            <!-- Chart Container -->
            <div class="chart-container">
                <canvas id="expenseChart" width="800" height="400"></canvas>
            </div>

        <!-- Script to render the chart -->
 <!-- Script to render the chart -->
 <script>
          // Chart Rendering
var ctx = document.getElementById('expenseChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: [<?php echo implode(',', range(1, $daysInMonth)); ?>], // Days of the month
        datasets: [{
            label: 'Expense for <?php echo date('F Y'); ?>',
            data: [<?php echo implode(',', $expenseData); ?>], // Expense data for each day
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: false // Start y-axis at the minimum expense value
                }
            }]
        }
    }
});

        </script>
    </div>
</body>
</html>
