<?php 
include('database.php');
include('function.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include('header.php');
check_auth();
check_admin_auth();
$msg = "";
$name = "";
$email = "";
$password = "";
$total_qr = "";
$total_hit = "";
$id = 0;
$password_required = "required";

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    $res = mysqli_query($con, "select * from users where id='$id'");
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_assoc($res);
        $name = $row['name'];
        $email = $row['email'];
        $password = $row['password'];
        $total_qr = $row['total_qr'];
        $total_hit = $row['total_hit'];
        $password_required = "";
    } else {
        redirect('users.php');
    }
}

if (isset($_POST['submit'])) {
    $name = get_safe_value($_POST['name']);
    $email = get_safe_value($_POST['email']);
    $password = password_hash(get_safe_value($_POST['password']), PASSWORD_DEFAULT);
    $total_qr = get_safe_value($_POST['total_qr']);
    $total_hit = get_safe_value($_POST['total_hit']);
    $role = 1;
    $status = 1;
    $added_on = date('Y-m-d h:i:s');
    
    $email_sql = "";
    if ($id > 0) {
        $email_sql = " and id!='$id'";
    }
    
    if (mysqli_num_rows(mysqli_query($con, "select * from users where email='$email' $email_sql")) > 0) {
        $msg = "Email id already used";
    } else {
        
        if ($id > 0) {
            $password_sql = "";
            if ($password != '') {
                $password_sql = ",password='$password'";
            }
            
            mysqli_query($con, "update users set name='$name',email='$email',total_qr='$total_qr',total_hit='$total_hit' $password_sql where id='$id'");
        } else {
            mysqli_query($con, "insert into users(name,email,password,total_qr,total_hit,role,status,added_on) values('$name','$email','$password','$total_qr','$total_hit','$role','$status','$added_on')");
        }

        // Sending password to the user's email
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'yashkumaradarsh6158@gmail.com';
            $mail->Password = 'jkcvlyhixghtnazd';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;

            //Recipients
          // Sender and recipient
            $mail->setFrom('yashkumaradarsh6158@gmail.com', 'SecureQRX');
            $mail->addAddress($email);

            //Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Your Password';
            $mail->Body = 'Your password is: ' . $_POST['password']; // Retrieve the password from the form field

            $mail->send();
            $msg .= '<br>Password sent successfully to ' . $email;
        } catch (Exception $e) {
            $msg .= '<br>Password could not be sent. Mailer Error: ' . $mail->ErrorInfo;
        }

        redirect('users.php');
    }
}
?>

<div class="page-wrapper">
    <div class="page-breadcrumb">
        <div class="row align-items-center">
            <div class="col-md-6 col-8 align-self-center">
                <h3 class="page-title mb-0 p-0">Manage User</h3>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form-horizontal form-material" method="post">
                            <div class="form-group">
                                <label for="example-email" class="col-md-12">Name</label>
                                <div class="col-md-12">
                                    <input type="name" placeholder="Enter Name" class="form-control pl-0 form-control-line" name="name" required value="<?php echo $name?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-email" class="col-md-12">Email</label>
                                <div class="col-md-12">
                                    <input type="email" placeholder="Email" class="form-control pl-0 form-control-line" name="email" required value="<?php echo $email?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-email" class="col-md-12">Password</label>
                                <div class="col-md-12">
                                    <input type="password" placeholder="Password" class="form-control pl-0 form-control-line" name="password" <?php echo $password_required?>>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-email" class="col-md-12">Total QR Codes</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="Total QR Codes" class="form-control pl-0 form-control-line" name="total_qr" value="<?php echo $total_qr?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="example-email" class="col-md-12">Total QR Hits</label>
                                <div class="col-md-12">
                                    <input type="text" placeholder="Total QR Hits" class="form-control pl-0 form-control-line" name="total_hit" value="<?php echo $total_hit?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 d-flex">
                                    <button class="btn btn-success mx-auto mx-md-0 text-white" name="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                        <div id="result"><?php echo $msg?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php')?>
