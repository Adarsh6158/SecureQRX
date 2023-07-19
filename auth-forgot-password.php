<?php
include('database.php');
include('function.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['forgot_password'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $email_query = "SELECT * FROM users WHERE email='$email'";
    $email_query_run = mysqli_query($con, $email_query);
    

if (!$email_query_run) {
    echo 'MySQL Error: ' . mysqli_error($link);
    exit();
}

    if (mysqli_num_rows($email_query_run) > 0) {
        $user_data = mysqli_fetch_assoc($email_query_run);
        $recipientName = $user_data['name'];
        // Generate a verification token
        $token = generateVerificationToken(); // Implement your own token generation logic

        // Store the token and associated email in the database or session
        storeVerificationToken($token, $email); // Implement your own token storage logic

        // Create an instance of PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'yashkumaradarsh6158@gmail.com';
            $mail->Password = 'jkcvlyhixghtnazd';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            // Sender and recipient
            $mail->setFrom('yashkumaradarsh6158@gmail.com', 'SecureQRX');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset';
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; background-color: #f8f8f8; padding: 20px;'>
                    <div style='background-color: #ffffff; padding: 20px; border-radius: 5px;'>
                        <h2 style='color: #003366;'>Password Reset</h2>
                        <p style='color: #333333; font-size: 16px;'>Dear $recipientName,</p>
                        <p style='color: #333333; font-size: 16px;'>We have received a request to reset your password. To proceed with the password reset, please click on the following link:</p>
                        <p style='text-align: center; margin-top: 30px;'><a href='http://localhost/SecureQRX/reset.php?token=$token' style='background-color: #007bff; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 4px; font-size: 16px;'>Reset Password</a></p>
                        <p style='color: #333333; font-size: 16px;'>If you did not initiate this request, please ignore this email.</p>
                        <p style='color: #333333; font-size: 16px;'><br>Adarsh </p>
                        <p style='color: #333333; font-size: 16px;'>SecureQRX</p>
                    </div>
                </div>
            ";
            
            

            // Send the email
            $mail->send();
            echo '<html>';
            echo '<head>';
            echo '<title>Password Reset</title>';
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
            echo '<style>';
            echo 'body {';
            echo '    background-color: #f8f8f8;';
            echo '    font-family: Arial, sans-serif;';
            echo '    margin: 0;';
            echo '    padding: 0;';
            echo '}';
            echo '.container {';
            echo '    display: none;';
            echo '    background-color: #ffffff;';
            echo '    padding: 20px;';
            echo '    border-radius: 5px;';
            echo '    margin: 20px auto;';
            echo '    max-width: 500px;';
            echo '}';
            echo 'h1 {';
            echo '    color: #003366;';
            echo '    margin-top: 0;';
            echo '}';
            echo 'p {';
            echo '    color: #333333;';
            echo '    font-size: 16px;';
            echo '}';
            echo '</style>';
            echo '</head>';
            echo '<body>';
            echo '<div class="container">';
            echo '<h1>Password Reset</h1>';
            echo '<p>Please check your email to proceed with the password reset.</p>';
            echo '</div>';
            echo '<script>';
            echo 'Swal.fire({';
            echo '    icon: "success",';
            echo '    title: "Email Sent",';
            echo '    html: document.querySelector(".container").innerHTML,';
            echo '    confirmButtonColor: "#3085d6",';
            echo '    confirmButtonText: "OK"';
            echo '}).then((result) => {';
            echo '    if (result.isConfirmed) {';
            echo '        document.querySelector(".container").style.display = "block";';
            echo '        window.location.href = "auth-forgot-password.php";';
            echo '    }';
            echo '});';
            echo '</script>';
            echo '</body>';
            echo '</html>';
            
            
            

            

           //Redirect the user to the verification page
          // header("location: auth-forgot-password.php");
           exit();
        } catch (Exception $e) {
            //Handle the error if email sending fails
          //echo '<script>alert("Email sending failed. Please try again later.");</script>';
           //echo '<script>window.location.href = "auth-forgot-password.php";</script>';
            echo '<html>';
            echo '<head>';
            echo '<title>Email Sending Problem</title>';
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
            echo '</head>';
            echo '<body>';
            echo '<script>';
            echo 'Swal.fire({';
            echo '    icon: "error",';
            echo '    title: "Email Sending Problem",';
            echo '    text: "There was a problem sending the email. Please try again later.",';
            echo '    confirmButtonColor: "#3085d6",';
            echo '    confirmButtonText: "OK"';
            echo '}).then((result) => {';
            echo '    if (result.isConfirmed) {';
            echo '        window.location.href = "auth-forgot-password.php";';
            echo '    }';
            echo '});';
            echo '</script>';
            echo '</body>';
            echo '</html>';

            
            exit();
        }
    } else {
        // Show error message if the email does not exist
        echo '<html>';
        echo '<head>';
        echo '<title>Email Not Found</title>';
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>';
        echo '</head>';
        echo '<body>';
        echo '<script>';
        echo 'Swal.fire({';
        echo '    icon: "error",';
        echo '    title: "Email Not Found",';
        echo '    text: "The provided email does not exist.",';
        echo '    confirmButtonColor: "#3085d6",';
        echo '    confirmButtonText: "OK"';
        echo '}).then((result) => {';
        echo '    if (result.isConfirmed) {';
        echo '        window.location.href = "auth-forgot-password.php";';
        echo '    }';
        echo '});';
        echo '</script>';
        echo '</body>';
        echo '</html>';
    }
}

function generateVerificationToken()
{
    // Generate a random token using a combination of letters and numbers
    $length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $token = '';
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $token;
}

function storeVerificationToken($token, $email)
{
    // Store the token and associated email in a session
    $_SESSION['verification_token'] = $token;
    $_SESSION['verification_email'] = $email;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <style>
        body {
            height: 100vh;
            background-color: #f8f9fa;
        }

        .container-fluid {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-base {
            overflow: hidden;
        }

        input[type="submit"] {
            background-color: #029565;
            border-color: #029565;
        }

        input[type="submit"]:hover {
            background-color: #02b078;
            border-color: #02b078;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="bg-light p-3 rounded-2 form-base col-12 col-sm-12 col-md-4">

            <!-- Form starts -->
            <form action="#" autocomplete="off" method="POST">

                <!-- Heading -->
                <h1 class="display-4 text-primary text-center mb-4"><b>Email Verification</b></h1>

                <!-- Input Email Field -->
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>

                <!-- Error Alert -->
                <div class="alert alert-danger d-none" role="alert" id="errorMsg">
                    Please enter a valid email address.
                </div>

                <!-- Submit and Back Button -->
                <div class="row justify-content-end mt-4">
                    <div class="col-4">
                        <button type="button" class="btn btn-secondary btn-block"
                            onclick="window.location.href = 'index.php';">Back</button>
                    </div>
                    <div class="col-4">
                        <button type="submit" name="forgot_password" class="btn btn-primary btn-block text-white">Verify</button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</body>

</html>
