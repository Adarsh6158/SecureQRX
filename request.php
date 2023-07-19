<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address";
        exit();
    }

    // Create a new PHPMailer instance
    $mail = new PHPMailer();

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
        $mail->addAddress('adarsh6158@gmail.com');

       // Content
$mail->isHTML(true);
$mail->Subject = 'New User Request';
$mail->Body = '
    <html>
    <head>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f1f1f1;
            }
            .container {
                background-color: #ffffff;
                border-radius: 5px;
                max-width: 600px;
                margin: 20px auto;
                padding: 20px;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            h1 {
                color: #003366;
                margin-top: 0;
            }
            p {
                color: #333333;
                font-size: 16px;
            }
            .btn {
                display: inline-block;
                font-size: 16px;
                padding: 10px 20px;
                background-color: #3085d6;
                color: #ffffff;
                text-decoration: none;
                border-radius: 5px;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Account Creation Request</h1>
            <p>A new user has requested an account. Please review the details below:</p>
            <p>Email: ' . $email . '</p>
            <a href="https://addykm.000webhostapp.com/" class="btn">Visit Website</a>
        </div>
    </body>
    </html>
';

        
        // Send the email
        $mail->send();

        // Display success message
        echo '<html>';
        echo '<head>';
        echo '<title>Account Creation Request</title>';
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
        echo '<h1>Account Creation Request</h1>';
        echo '<p>You will get your Login credentails at mail</p>';
        echo '</div>';
        echo '<script>';
        echo 'Swal.fire({';
        echo '    icon: "success",';
        echo '    title: "Your account will be approved in a few hours",';
        echo '    html: document.querySelector(".container").innerHTML,';
        echo '    confirmButtonColor: "#3085d6",';
        echo '    confirmButtonText: "OK"';
        echo '}).then((result) => {';
        echo '    if (result.isConfirmed) {';
        echo '        document.querySelector(".container").style.display = "block";';
        echo '        window.location.href = "index.php";';
        echo '    }';
        echo '});';
        echo '</script>';
        echo '</body>';
        echo '</html>';
        exit();
    } catch (Exception $e) {
        echo "Error occurred: " . $mail->ErrorInfo;
    }
}
?>

<!DOCTYPE html>
<html dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="icon" href="logo.png" type="image/x-icon">
    <link href="css/login.css" rel="stylesheet">
    <link href="css/core.css" rel="stylesheet">
</head>
<body>
    <div class="main-wrapper">
        <div class="auth-wrapper d-flex no-block justify-content-center align-items-center" style="background: url(background.jpg) no-repeat center center / cover;">
            <div class="auth-box p-4 bg-white rounded">
                <div id="loginform">
                    <div class="logo">
                        <h3 class="box-title mb-3">Account Creation</h3>
                    </div>
                    <!-- Form -->
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal mt-3 form-material" method="post" id="frmLogin">
                                <div class="form-group mb-3">
                                    <div class="">
                                        <input class="form-control" type="email" name="email" required="" placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group text-center mt-4">
                                    <div class="col-xs-12">
                                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" id="btnLogin" name="submit">Log In</button>
                                    </div>
                                </div>
                               
                                
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/plugins/jquery/dist/jquery.min.js"></script>
    <script src="assets/plugins/popper.js/dist/umd/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="js/core.js"></script>
    <script>
        $('[data-toggle="tooltip"]').tooltip();
        $(".preloader").fadeOut();
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
    </script>
</body>
</html>

