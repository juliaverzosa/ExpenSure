<?php 
    include_once "init.php";
    
    // User login check
    if (isset($_SESSION['UserID'])) {
      header('Location: dashboard.php');
    }

    // Validate credentials and log the user in
    if (isset($_POST['login']) && !empty($_POST)) {
        $password = $_POST['password'];
        $username = $_POST['username'];
        
        if(!empty($username) || !empty($password)) {
            $username = $getFromU->checkInput($username);
            $password = $getFromU->checkInput($password);
            if($getFromU->login($username, $password) === false) {
            $error = "The username or password is incorrect";
            }
          } 
    }
    if(isset($_POST['register']))
          {
      
              $fullname = $_POST['full_name'];
              $username = $_POST['username'];
              $password = $_POST['password'];
              $email = $_POST['email'];
              $signupError = "";
      
              // Form validation
              $email = $getFromU->checkInput($email);
              $fullname = $getFromU->checkInput($fullname);
              $username = $getFromU->checkInput($username);
              $password = $getFromU->checkInput($password);
      
              if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
              {
                  $signupError = "Invalid email";
              } 
              elseif (strlen($fullname) > 30 || (strlen($fullname)) < 2) 
              {
                  $signupError = "Name must be between 2-30 characters";
              } 
              elseif (strlen($username) > 30 || (strlen($username)) < 3) 
              {
                  $signupError = "Username must be between 3-30 characters";
              } 
              elseif (strlen($password) < 6) 
              {
                  $signupError = "Password too short";
              }
              elseif (strlen($password) >30) 
              {
                  $signupError = "Password too long";
              }
              else 
              {
                  if ($getFromU->checkEmail($email) === true) 
                  {
                      $signupError = "Email already registered";
                  } 
              
                  if ($getFromU->checkUsername($username) === true) 
                  {
                      $signupError = "Username already exists";
                  }
                  else 
                  {
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
                      header('Location: dashboard.php');
                  }
                }
    }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="signIn.css">
    <title>Login Page</title>
</head>

<body>

    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="index.php" method="post" id="form" onsubmit="return validate()" enctype="multipart/form-data">
                <h1>Create Account</h1>
                <input class="fname" onkeypress="return (event.charCode > 64 && 
                event.charCode < 91) || (event.charCode > 96 && event.charCode < 123) || (event.charCode==32)" type="text" name="full_name" id="fullname" minlength="2" maxlength="30" placeholder="Full Name" required>
                <input type="email" name="email" id="email" placeholder="Email">
                <input type="text" name="username" id="username" placeholder="Username" minlength="3" maxlength="30" required>
                <span id="uname_response" style="font-family: 'Source Sans Pro'; font-size:0.8em ; color:red; font-weight:bold"></span>

                <input type="password" name="password" id="password" placeholder="Password" minlength="6" maxlength="30" autocomplete="on" required>
                <input type="password" name="password_confirm" id="confirmpassword" minlength="6" maxlength="30" placeholder="Confirm Password" autocomplete="on" required>
                <button type="submit" value="Submit" name="register">Complete</button>
                <?php  
                if (isset($signupError)) {
                    $font = "Source Sans Pro";
                    echo '<div style="color: red;font-family:'.$font.';">'.$signupError.'</div>';
                }
	        ?>
            </form>
        </div>
        <div class="form-container sign-in">
        <form action="index.php" method="post" onsubmit = "return validate()" id="form1">
                <h1>Sign In</h1>
                <input type="text" name="username" placeholder="Username" id="user1" required>
                <input type="password" name="password" placeholder="Password" id="pass1" autocomplete="on" required>
                <a href="#">Forget Your Password?</a>
                <button type="submit" class="sign-in" name="login">Sign In</button>

                <br>
            <?php
                if (isset($error)) {
                    $font = "Source Sans Pro";
                    echo '<div style="color:  red;font-family:'.$font.';">'.$error.'</div>';
                }
            ?>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>
    <script src="signIn.js"></script>
    <script src="signUp.js"></script>

</body>
</html>


</body>

</html>