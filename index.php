<?php
include('database.php');
include('function.php');
$msg="";
if(isset($_SESSION['QR_USER_LOGIN'])){
	redirect('qr_codes.php');
}
if(isset($_POST['submit'])){
	$email=get_safe_value($_POST['email']);
	$password=get_safe_value($_POST['password']);
	
	$res=mysqli_query($con,"select * from users where email='$email'");
	if(mysqli_num_rows($res)>0){
		$row=mysqli_fetch_assoc($res);
		$status=$row['status'];
		if($status==0){
			$msg="Account deactivated";
		}else{
			$db_password=$row['password'];
			if(password_verify($password,$db_password)){
				$_SESSION['QR_USER_LOGIN']=true;
				$_SESSION['QR_USER_ID']=$row['id'];
				$_SESSION['QR_USER_NAME']=$row['name'];
				$_SESSION['QR_USER_ROLE']=$row['role'];
				redirect('profile.php');
			}else{
				$msg="Please enter correct password";
			}
		}
	}else{
		$msg="Please enter valid login details";
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
                        <h3 class="box-title mb-3">Sign In</h3>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <form class="form-horizontal mt-3 form-material" method="post" id="frmLogin">
                                <div class="form-group mb-3">
                                    <div class="">
                                        <input class="form-control" type="email" name="email" required="" placeholder="Email"> </div>
                                </div>
                                <div class="form-group mb-4">
                                    <div class="">
                                        <input class="form-control" type="password" name="password" required="" placeholder="Password"> </div>
                                </div>
                                <div class="form-group text-center mt-4">
                                    <div class="col-xs-12">
                                        <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit" id="btnLogin" name="submit">Log In</button>
                                    </div>
                                </div>
                                <div class="text-center mt-5">
                                <p class="text-gray-600 fs-4">If you are a new user and don't have an account</p>
                                <a href="request.php" class="font-bold fs-4 text-primary">Request Admin for an Account</a>
                            </div>

                            <div class="row justify-content-center mt-3">
                                <div class="col-xs-12 col-lg-6 text-center">
                                    <a href="auth-forgot-password.php" class="font-bold fs-4 text-primary">Forgot Password?</a>
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