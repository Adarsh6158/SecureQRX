<?php
include('database.php');
include('function.php');

$cur_page=$_SERVER['SCRIPT_NAME'];
$cur_page_arr=explode("/",$cur_page);
$cur_page=$cur_page_arr[count($cur_page_arr)-1];

$user_selected="";
if($cur_page=="users.php" || $cur_page=="manage_users.php"){
	$user_selected="active";
}

$profile_selected="";
if($cur_page=="profile.php"){
	$profile_selected="active";
}

$qr_selected="";
if($cur_page=="manage_qr_code.php" || $cur_page=="qr_report.php"  || $cur_page=="qr_detail_report.php"){
	$qr_selected="active";
}
?>
<!DOCTYPE html>
<html dir="ltr" lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>QR Codes</title>
      <link rel="icon" href="logo.png" type="image/x-icon">
      <link href="css/style.min.css" rel="stylesheet">
     
   </head>
   <body>
      <div class="preloader">
         <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
         </div>
      </div>
      <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
         data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
         <header class="topbar" data-navbarbg="skin6">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
               <div class="navbar-header" data-logobg="skin6">
                  <a class="navbar-brand ml-4" href="index.php">
                  <span class="logo-text">
                  <img src="assets/images/logo-light-text.png" alt="homepage" class="dark-logo" />
                  </span>
                  </a>
                  <a class="nav-toggler waves-effect waves-light text-white d-block d-md-none"
                     href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
               </div>
               <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
                  <ul class="navbar-nav mr-auto mt-md-0 ">
                     <li class="nav-item search-box">
                        &nbsp;
                     </li>
                  </ul>
                  <ul class="navbar-nav">
                     <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href=""
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Welcome <?php echo $_SESSION['QR_USER_NAME']?></a>
                     </li>
                  </ul>
               </div>
            </nav>
         </header>
         <aside class="left-sidebar" data-sidebarbg="skin6">
            <div class="scroll-sidebar">
               <nav class="sidebar-nav">
                  <ul id="sidebarnav">
					<li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link <?php echo $qr_selected?>" href="qr_codes.php" aria-expanded="false"><i class="mdi mdi-qrcode"></i><span class="hide-menu">QR Code</span></a>
                     </li>
					 <?php
					 if($_SESSION['QR_USER_ROLE']==0){
					 ?>
					 <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link <?php echo $user_selected?>" href="users.php" aria-expanded="false"><i class="mdi mdi-account"></i><span class="hide-menu">Users</span></a>
                     </li>
					 <?php } ?>
					 <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link <?php echo $profile_selected?>" href="profile.php" aria-expanded="false"><i class="mdi mdi-account-key"></i><span class="hide-menu">Profile</span></a>
					 
                     <li class="sidebar-item"> <a class="sidebar-link waves-effect waves-dark sidebar-link" href="logout.php" aria-expanded="false"><i class="mdi mr-2 mdi-logout"></i><span class="hide-menu">Logout</span></a>
                     </li>
					 
					 <?php
					 $getUserInfo=getUserInfo($_SESSION['QR_USER_ID']);
					 if($getUserInfo['role']==1){
					 $getUserTotalQR=getUserTotalQR($_SESSION['QR_USER_ID']);	
					 $totalUserQRHitListRes=getUserTotalQRHit($_SESSION['QR_USER_ID']);
					 ?>
					 
					 <b>Total QR Code Created <?php echo $getUserTotalQR['total_qr']?>
					 Total QR Hits <?php echo $totalUserQRHitListRes['total_hit']?>
					 </b>
					 <?php } ?>
                  </ul>
               </nav>
            </div>
         </aside>
         