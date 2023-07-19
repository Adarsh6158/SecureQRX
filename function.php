<?php
function pr($arr){
	echo "<pre>";
	print_r($arr);
}

function prx($arr){
	echo "<pre>";
	print_r($arr);
	die();
}

function get_safe_value($str){
	global $con;
	if($str!=''){
		return mysqli_real_escape_string($con,$str);
	}
}

function redirect($link){
	?>
	<script>
	window.location.href='<?php echo $link?>';
	</script>
	<?php
}

function check_auth(){
	if(!isset($_SESSION['QR_USER_LOGIN'])){
		redirect('index.php');
	}
}

function check_admin_auth(){
	if($_SESSION['QR_USER_ROLE']!=0){
		redirect('profile.php');
	}
}

function getCustomDate($date){
	if($date!=''){
		$date=strtotime($date);
		return date('d-M Y',$date);
	}
}

function getUserInfo($uid){
	global $con;
	$row=mysqli_fetch_assoc(mysqli_query($con,"select * from users where id='$uid'"));
	return $row;
}

function getUserTotalQR($uid){
	global $con;
	$row=mysqli_fetch_assoc(mysqli_query($con,"select count(*) as total_qr from qr_code where added_by='$uid'"));
	return $row;
}

function getUserTotalQRHit($uid){
	global $con;
	$row=mysqli_fetch_assoc(mysqli_query($con,"SELECT count(*) as total_hit from qr_traffic, qr_code, users WHERE qr_traffic.qr_code_id=qr_code.id and qr_code.added_by=users.id and users.id='".$uid."'"));
	return $row;
}
?>