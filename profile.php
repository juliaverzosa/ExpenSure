<?php 
    include_once "init.php";

    // User login check
    if ($getFromU->loggedIn() === false) {
        header('Location:index.php');
    }
 
    // Gathering all user data
    $userobj = $getFromU->userData($_SESSION['UserID']);
    $fullname = $userobj->Full_Name;
    $usr_name = $userobj->Username;
    $emailid = $userobj->Email;
    $JoinDate = $userobj->Registration_Date;
    // $picture = $userobj->Photo;
?>      

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="main.css">
<link rel="stylesheet" href="profile.css">

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
            <!-- <input type="checkbox" id="theme-toggle" hidden>
            <label for="theme-toggle" class="theme-toggle"></label> -->
            <!-- <a href="#" class="notif">
                <i class='bx bx-bell'></i>
                <span class="count">12</span>
            </a> -->
            <a href="profile.php" class="profile" id="profile-icon">
            <img src="user.png">
        </a>
        </nav>
        <!-- End of Navbar -->

    <main>
    <div class="header">
        <div class="left">
            <h1>Your Profile</h1>
        </div>
    </div>

    <!-- Profile Form Page-->
    <div id="profile-page" class="profile-page">
    <div class="profile-form">
        <div class="card">
            <div class="profile-picture">
                <img src="user.png">
            </div>
            <div class="user-info">
                <div class="form-group">
                    <label for="full-name">Full Name:</label>
                    <input type="text" id="full-name" class="text-input" value="<?php echo $fullname; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" class="text-input" value="<?php echo $usr_name; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" class="text-input" value="<?php echo $emailid; ?>" readonly>
                </div>
                <div class="form-group">
                    <label for="registration-date">Registration Date:</label>
                    <input type="datetime" id="registration-date" class="text-input" value="<?php echo $JoinDate; ?>" readonly>
                </div>
               
            </div>
        </div>
    </div>
</div>

</div>
</main>

<script> src="profile.js"</script>
<script src="index.js"></script>
</body>
