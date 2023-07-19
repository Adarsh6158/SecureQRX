<?php
include('database.php');
include('function.php');
$password_error = '';
$match_error = '';

if(isset($_POST['submit']))
{
    $email = $_POST['email'];
    $pass = $_POST['password'];
    $repass = $_POST['Repassword'];

    if($pass == $repass){
        // Validate password requirements
        $password_pattern = "/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>])(?!.*\s).{8,}$/";
        if(!preg_match($password_pattern, $pass)){
            $password_error = "Password should contain at least 8 characters, including:";
            $password_error .= "<ul>";
            $password_error .= "<li>At least one uppercase letter</li>";
            $password_error .= "<li>At least one lowercase letter</li>";
            $password_error .= "<li>At least one digit</li>";
            $password_error .= "<li>At least one special character</li>";
            $password_error .= "</ul>";
        }
        else {
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT); // Hash the new password

            $sql = "UPDATE users SET password='$hashed_password' WHERE email='$email'";
            $pass_query_run = mysqli_query($con, $sql);
            if($pass_query_run){
                echo "Congratulations! You have successfully changed your password";
                header("location:index.php");
                exit();
            } else {
                echo "An error occurred while updating the password.";
            }
        }
    } else {
        $match_error = "Passwords do not match";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forget Password</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        .container {
            max-width: 400px;
        }

        .error-message {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .error-message ul {
            list-style-type: disc;
            margin-left: 1.5rem;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="text-center">
            <h1 class="display-4 mb-4">Forget Password</h1>
        </div>
        <form class="p-4 bg-white rounded shadow-sm" method="post" action="#" autocomplete="off">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" name="email" placeholder="Email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" name="password" placeholder="New Password" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">Confirm Password</label>
                <input type="password" name="Repassword" placeholder="Confirm Password" class="form-control" required>
                <?php if(!empty($password_error)) { ?>
                    <div class="error-message"><?php echo $password_error; ?></div>
                <?php } ?>
                <?php if(!empty($match_error)) { ?>
                    <div class="alert alert-danger"><?php echo $match_error; ?></div>
                <?php } ?>
            </div>
            <button type="submit" name="submit" class="btn btn-primary btn-block">Reset Password</button> 
        </form>
    </div>
</body>
</html>
