<?php
include_once "init.php";

// User login checker
if ($getFromU->loggedIn() === false) {
    header('Location: index.php');
}

// Fetch predefined categories from the database
$categories = $getFromC->getAll();

// Initialize error variable
$error = '';

// Create an expense record
if (isset($_POST['addexpense'])) {
    $dt = DateTime::createFromFormat('Y-m-d\TH:i', $_POST['dateexpense']);
    $formattedDt = $dt ? $dt->format('Y-m-d H:i:s') : false;
    $itemname = $_POST['item'];
    $itemcost = $_POST['costitem'];
    $categoryID = $_POST['category']; // Get the category from the form

    $currentDate = new DateTime();

    // Set the time to 00:00:00 for both current date and selected date to compare only dates
    $currentDate->setTime(0, 0, 0);
    $dt->setTime(0, 0, 0);

    if ($formattedDt === false || $dt > $currentDate) {
        $error = "Date cannot be in the future.";
    } else {
        $getFromE->create("expense", array(
            'UserID' => $_SESSION['UserID'],
            'Item' => $itemname,
            'Cost' => $itemcost,
            'Date' => $formattedDt,
            'CategoryID' => $categoryID // Save the category ID to the database
        ));

        $success = "Expense added successfully";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="add-expenses.css">
    <title>Add Expenses</title>
    <style>
        .success-message {
            color: #2ecc71;
            text-align: center;
        }
    </style>
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
        <!-- End of Navbar -->

        <main>
            <div class="header">
                <div class="left">
                    <h1>Add Expenses</h1>
                </div>
            </div>
            <div class="card">
                <div class="counter">
                    <form action="" method="post" class="expense-form">
                        <?php if (!empty($success)) : ?>
                            <p class="success-message"><?php echo $success; ?></p>
                        <?php endif; ?>
                        <?php if (!empty($error)) : ?>
                            <p class="error"><?php echo $error; ?></p>
                        <?php endif; ?>
                        <div>
                            <label for="dateexpense" class="form-label">Date of Expense:</label><br><br>
                            <input id="dateexpense" class="text-input" type="datetime-local" name="dateexpense" required><br><br>
                        </div>
                        <div>
                            <label for="item" class="form-label">Item:</label><br>
                            <input id="item" type="text" class="text-input" name="item" required><br><br>
                        </div>
                        <div>
                            <label for="costitem" class="form-label">Cost of Item:</label><br>
                            <input id="costitem" class="text-input" type="text" name="costitem" required placeholder="₱₱₱" onkeypress='validate(event)'><br><br>
                        </div>
                        <div>
                            <label for="category" class="form-label">Category:</label><br><br>
                            <select id="category" class="text-input" name="category" required>
                                <?php foreach ($categories as $category) : ?>
                                    <option value="<?php echo $category->CategoryID; ?>"><?php echo $category->CategoryName; ?></option>
                                <?php endforeach; ?>
                            </select><br><br>
                        </div>
                        <div><br>
    <button type="submit" class="pressbutton" name="addexpense">Add</button>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
</div>
                    </form>
                </div>
            </div>
        </main>
        <script src="index.js"></script>
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                const expenseForm = document.querySelector(".expense-form");

                expenseForm.addEventListener("submit", function(event) {
                    const dateExpense = document.getElementById("dateexpense").value;
                    const selectedDate = new Date(dateExpense);
                    const currentDate = new Date();

                    if (selectedDate > currentDate) {
                        event.preventDefault();
                        showError("Date cannot be in the future.");
                    }
                });

                function showError(message) {
                    let errorElement = document.getElementById("form-error");
                    if (!errorElement) {
                        errorElement = document.createElement("p");
                        errorElement.id = "form-error";
                        errorElement.className = "error";
                        expenseForm.appendChild(errorElement);
                    }
                    errorElement.textContent = message;
                }
            });
            
        </script>
        
    </div>
</body>
</html>
