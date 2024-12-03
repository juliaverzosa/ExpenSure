<?php
include_once "init.php";

// User login check
if (isset($_SESSION['UserID'])) {
    header('Location:dashboard.php');
}

// Initialize error type
$errorType = null;

// Validate credentials and log the user in
if (isset($_POST['login']) && !empty($_POST)) {
    $password = $_POST['password'];
    $username = $_POST['username'];

    if (!empty($username) || !empty($password)) {
        $username = $getFromU->checkInput($username);
        $password = $getFromU->checkInput($password);
        if ($getFromU->login($username, $password) === false) {
            $error = "The username or password is incorrect";
            $errorType = 'login';
        }
    }
}

// User registration
if (isset($_POST['register'])) {
    $fullname = $_POST['full_name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = $_POST['email'];
    $signupError = "";

    // Form validation
    $email = $getFromU->checkInput($email);
    $fullname = $getFromU->checkInput($fullname);
    $username = $getFromU->checkInput($username);
    $password = $getFromU->checkInput($password);
    $confirm_password = $getFromU->checkInput($confirm_password);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signupError = "Invalid email";
    } elseif (strlen($fullname) > 30 || (strlen($fullname)) < 2) {
        $signupError = "Name must be between 2-30 characters";
    } elseif (strlen($username) > 30 || (strlen($username)) < 3) {
        $signupError = "Username must be between 3-30 characters";
    }elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username)) {
            $signupError = "Username can only contain letters, numbers, and underscores";
    } elseif (strlen($password) < 6) {
        $signupError = "Password too short";
    } elseif (strlen($password) > 30) {
        $signupError = "Password too long";
    } elseif ($password !== $confirm_password) {
        $signupError = "Passwords do not match";
    } else {
        if ($getFromU->checkEmail($email)) {
            $signupError = "Email already registered";
        } elseif ($getFromU->checkUsername($username)) {
            $signupError = "Username already exists";
        } else {
            $user_id = $getFromU->create('user', array('Email' => $email,'Password' => md5($password), 'Full_Name' => $fullname, 'Username' => $username, 'Registration_Date' => date("Y-m-d H:i:s")));
            $_SESSION['UserID'] = $user_id;
            $_SESSION['swal'] = "<script>
                Swal.fire({
                    title: 'Yay!',
                    text: 'Congrats! You are now a registered user',
                    icon: 'success',
                    confirmButtonText: 'Done'
                })
                </script>";
            header('Location:dashboard.php');
        }
    }
    $errorType = 'register';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="style.css" />
    <title>Sign in & Sign up Form</title>
    <style>
        .error {
            color: red;
            margin-top: 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container <?php if ($errorType == 'register') echo 'sign-up-mode'; ?>">
        <div class="forms-container">
            <div class="signin-signup">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="sign-in-form">
                    <div class="logo-container">
                        <i class='bx bxs-wink-smile logo-icon'></i>
                        <div class="logo-name"><span>Expen</span>Sure</div>
                    </div>
                    <h2 class="title">Sign in</h2>
                    <p class="welcome-text">
                        Welcome back! Please enter your details.
                    </p>
                    <div class="input-field">
                        <i class="bx bxs-user"></i>
                        <input type="text" placeholder="Username" name="username" />
                    </div>
                    <div class="input-field">
                        <i class="bx bxs-lock"></i>
                        <input type="password" placeholder="Password" name="password" />
                    </div>
                    <input type="submit" value="Login" name="login" class="btn solid" />
                    <?php if (isset($error) && $errorType == 'login') echo "<p class='error'>$error</p>"; ?>
                </form>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" class="sign-up-form">
                    <h2 class="title">Sign up</h2>
                    <div class="input-field">
                        <i class="bx bx-id-card"></i>
                        <input type="text" placeholder="Name" name="full_name" />
                    </div>
                    <div class="input-field">
                        <i class="bx bxs-user"></i>
                        <input type="text" placeholder="Username" name="username" />
                    </div>
                    <div class="input-field">
                        <i class="bx bxs-envelope"></i>
                        <input type="email" placeholder="Email" name="email" />
                    </div>
                    <div class="input-field">
                        <i class="bx bxs-lock"></i>
                        <input type="password" placeholder="Password" name="password" />
                    </div>
                    <div class="input-field">
                        <i class="bx bxs-lock"></i>
                        <input type="password" placeholder="Confirm Password" name="confirm_password" />
                    </div>
                    <input type="submit" class="btn" value="Sign up" name="register" />
                    <?php if (isset($signupError)) echo "<p id='signup-error' class='error'>$signupError</p>"; ?>
                </form>
            </div>
        </div>

        <div class="panels-container">
            <div class="panel left-panel">
                <div class="content">
                    <h3>New here?</h3>
                    <p>
                       
    Welcome to ExpenSure! Ready to dive into the world of financial management? Let's start your journey to financial success together!
                    </p>
                    <button class="btn transparent" id="sign-up-btn">
                        Sign up
                    </button>
                </div>
                <img src="img/signup.png" class="image" alt="" />
            </div>
            <div class="panel right-panel">
                <div class="content">
                    <h3>Already have an account?</h3>
                    <p>
                    Ah, a seasoned ExpenSure user, are you? Ready to jump back into managing those expenses like a pro? Let's get you back on track!
                    </p>
                    <button class="btn transparent" id="sign-in-btn">
                        Sign in
                    </button>
                </div>
                <img src="img/login.png" class="image" alt="" />
            </div>
        </div>
    </div>
    <script src="app.js"></script>
</body>
</html>
