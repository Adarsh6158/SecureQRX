<?php 
include('header.php');
check_auth();
$msg="";
$id=$_SESSION['QR_USER_ID'];
$res=mysqli_query($con,"select * from users where id='$id'");
if(mysqli_num_rows($res)>0){
	$row=mysqli_fetch_assoc($res);
	$name=$row['name'];
	$email=$row['email'];
	$total_qr=$row['total_qr'];
	$total_hit=$row['total_hit'];
}else{
	redirect('users.php');	
}

if(isset($_POST['submit'])){
	$name=get_safe_value($_POST['name']);
	$password=password_hash(get_safe_value($_POST['password']),PASSWORD_DEFAULT);
	$password_sql="";
	if($password!=''){
		$password_sql=",password='$password'";
	}
	mysqli_query($con,"update users set name='$name' $password_sql where id='$id'");
}
?>
<div class="page-wrapper">
<div class="page-breadcrumb">
   <div class="row align-items-center">
      <div class="col-md-6 col-8 align-self-center">
      <h3 class="mb-0 p-0">Manage Profile</h3>
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
                        <input type="email" placeholder="Email" class="form-control pl-0 form-control-line" name="email" disabled value="<?php echo $email?>">
                     </div>
                  </div>
				  <div class="form-group">
                     <label for="example-email" class="col-md-12">Password</label>
                     <div class="col-md-12">
                        <input type="password" placeholder="Password" class="form-control pl-0 form-control-line" name="password">
                     </div>
                  </div>
				  <?php
				  $getUserInfo=getUserInfo($_SESSION['QR_USER_ID']);
				  if($getUserInfo['role']==1){?>
				  <div class="form-group">
                     <label for="example-email" class="col-md-12">Total QR Codes</label>
                     <div class="col-md-12">
                        <input type="text" placeholder="Total QR Codes" class="form-control pl-0 form-control-line" name="total_qr" value="<?php echo $total_qr?>" disabled>
                     </div>
                  </div>
				  <div class="form-group">
                     <label for="example-email" class="col-md-12">Total QR Hits</label>
                     <div class="col-md-12">
                        <input type="text" placeholder="Total QR Hits" class="form-control pl-0 form-control-line" name="total_hit" value="<?php echo $total_hit?>" disabled>
                     </div>
                  </div>
				  <?php } ?>
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

<?php include('footer.php')?>