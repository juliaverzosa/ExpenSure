<?php 
    include_once "init.php";

    // User login check
    if ($getFromU->loggedIn() === false) {
        header('Location: index.php');
    }

    // Password validation and change
    if(isset($_POST['changepwd']))
    {

        $old_pass_hash = $getFromU->userData($_SESSION['UserID'])->Password;
        $confirmpass = md5($_POST['oldpass']);
        function function_alert($message) {   
            echo "<script>
            Swal.fire({
                title: '',
                text: '$message',
                icon: '',
                confirmButtonText: 'Okay!'
            })
            </script>";
        } 
        if($confirmpass === $old_pass_hash)
        {
            $getFromU->update('user',$_SESSION['UserID'], array('Password' => md5($_POST['newpass'])));
            function_alert("Password Updated Successfully");
        }
        else
        {
            function_alert("Could Not Change Password");
        }
    }

?>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="main.css">


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
        <li><a href="manage-expenses.php"><i class='bx bx-edit'></i>Manage Expense</a></li>
        <li><a href="report.php"><i class='bx bxs-report'></i>Report</a></li>
        <li><a href="#"><i class='bx bx-cog'></i>Settings</a></li>
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
        <form action="#">
            <div class="form-input">
                <input type="search" placeholder="Search...">
                <button class="search-btn" type="submit"><i class='bx bx-search'></i></button>
            </div>
        </form>

        <a href="profile.php" class="profile" id="profile-icon">
            <img src="user.png">
        </a>
    </nav>
    <!-- End of Navbar -->

<div class="wrapper">
        <div class="row">
            <div class="col-12 col-m-12 col-sm-12" >
                <div class="card">
                    <div class="counter" style="height: 60vh; display: flex; align-items: center; justify-content: center;">
                    <form action="" method="post" onsubmit="return validate()" id="form">
								
								<div class="formcontrol">
									<label style="font-family: 'Source Sans Pro'; font-size: 1.3em; ">Current Password:</label><br>
									<input type="password" class="text-input" name="oldpass" id="oldpass" value="" required="true" style="padding-top: 10px; "><br>
                                    <small></small>
                                </div>
                                <div class="formcontrol">
									<label style="font-family: 'Source Sans Pro'; font-size: 1.3em; ">New Password:</label><br>
									<input type="password" class="text-input" name="newpass" id="newpass" value="" required="true" style="padding-top: 10px; "><br>
                                    <small></small>
                                </div>
                                <div class="formcontrol">
									<label style="font-family: 'Source Sans Pro'; font-size: 1.3em; ">Re-Type Password:</label><br>
									<input type="password" class="text-input" name="cnewpass" id="cpass" value="" required="true" style="padding-top: 10px; "><br>
                                    <small></small>
                                </div>
																
								<div><br>
									<button type="submit" class="pressbutton" name="changepwd">Change Password</button>
								</div>								
								
								</div>
								
							</form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</body>
    <script src="changepass.js"></script>
    <link rel="stylesheet" src="../static/css/11-changepass.css">