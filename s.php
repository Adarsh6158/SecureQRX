<?php
include('database.php');
include('function.php');

include('lib/BrowserDetection.php');
include('lib/Mobile_Detect.php');



if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
	
	$res=mysqli_query($con,"select added_by,link from qr_code where id='$id' and status='1'");
	if(mysqli_num_rows($res)>0){
		$row=mysqli_fetch_assoc($res);
		$link=$row['link'];
		$added_by=$row['added_by'];
		
		$getUserInfo=getUserInfo($added_by);
		
		if($getUserInfo['total_hit']!=0){
			$totalUserQRHitListRes=getUserTotalQRHit($added_by);
			if($getUserInfo['total_hit']<($totalUserQRHitListRes['total_hit']+1)){
                die(showErrorAndRedirect('Invalid QR Code or QR Code is not active.', 'index.php'));
			}
		}
		
		$device="";
		$os="";
		$detect=new Mobile_Detect();
		$browserObj=new Wolfcast\BrowserDetection;
		$browser=$browserObj->getName();

		if($detect->isMobile()){
			$device="Mobile";
		}elseif($detect->isTablet()){
			$device="Tablet";
		}else{
			$device="PC";
		}

		if($detect->isiOS()){
			$os="iOS";
		}elseif($detect->isAndroidOS()){
			$os="Android";
		}else{
			$os="Window";
		}
        $ip_address = $_SERVER['REMOTE_ADDR'];
        $api_url = "http://ip-api.com/json/" . $ip_address;
		$ch=curl_init();
	    curl_setopt($ch, CURLOPT_URL, $api_url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$result=curl_exec($ch);
		curl_close($ch);
		$result=json_decode($result,true);
		$city=$result['city'];
		$state=$result['regionName'];
		$country=$result['country'];
		$ip_address=$result['query'];
		$added_on=date('Y-m-d h:i:s');
		$added_on_str=date('Y-m-d');
		
		mysqli_query($con,"insert into qr_traffic(qr_code_id,device,os,browser,city,state,country,added_on,ip_address,added_on_str) values('$id','$device','$os','$browser','$city','$state','$country','$added_on','$ip_address','$added_on_str')");
		
		redirect($link);
		
	}else{
		die(showErrorAndRedirect('Invalid QR Code or QR Code is not active.', 'index.php'));
	}
}

function showErrorAndRedirect($errorMessage, $redirectURL) {
    echo '
    <html>
    <head>
        <title>Error</title>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <style>
            body {
                background-color: #f8f8f8;
                font-family: Arial, sans-serif;
                margin: 0;
                padding: 0;
            }
            .container {
                display: none;
                background-color: #ffffff;
                padding: 20px;
                border-radius: 5px;
                margin: 20px auto;
                max-width: 500px;
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
            <h1>Error</h1>
            <p>' . $errorMessage . '</p>
            <a href="' . $redirectURL . '" class="btn">Back to Home</a>
        </div>
        <script>
            Swal.fire({
                icon: "error",
                title: "Error",
                text: "' . $errorMessage . '",
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Back to Home"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "' . $redirectURL . '";
                }
            });
        </script>
    </body>
    </html>';
		}
?>