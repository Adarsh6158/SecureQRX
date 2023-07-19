<?php 
include('header.php');
check_auth();

if(isset($_GET['id']) && $_GET['id']>0){
	
	$condition="";
	if($_SESSION['QR_USER_ROLE']==1){
		$condition=" and qr_code.added_by='".$_SESSION['QR_USER_ID']."'";
	}
	
	$id=get_safe_value($_GET['id']);
	
	$res=mysqli_query($con,"select count(*) as total_record, qr_traffic.*,qr_code.name from qr_traffic,qr_code where qr_traffic.qr_code_id=qr_code.id and qr_code.id='$id' $condition group by qr_traffic.added_on_str");
	if(mysqli_num_rows($res)>0){
		while($row=mysqli_fetch_assoc($res)){
			$arr[]=$row;
		}	
	}else{
		redirect('qr_codes.php');
	}
	
	$totalCount=0;
	foreach($arr as $list){
		$totalCount+=$list['total_record'];
	}
	
	$resDevice=mysqli_query($con,"select count(*) as total_record, device from qr_traffic where qr_code_id='$id' group by qr_traffic.device");
	$deviceChartStr="";
	while($rowDevice=mysqli_fetch_assoc($resDevice)){
		 $deviceChartStr.="['".$rowDevice['device']."',     ".$rowDevice['total_record']."],";
	}
	$deviceChartStr=rtrim($deviceChartStr,",");
	
	
	$resOS=mysqli_query($con,"select count(*) as total_record, os from qr_traffic where qr_code_id='$id' group by qr_traffic.os");
	$osChartStr="";
	while($rowOS=mysqli_fetch_assoc($resOS)){
		 $osChartStr.="['".$rowOS['os']."',     ".$rowOS['total_record']."],";
	}
	$osChartStr=rtrim($osChartStr,",");
	
	$resBrowser=mysqli_query($con,"select count(*) as total_record, browser from qr_traffic where qr_code_id='$id' group by qr_traffic.browser");
	$browserChartStr="";
	while($rowBrowser=mysqli_fetch_assoc($resBrowser)){
		 $browserChartStr.="['".$rowBrowser['browser']."',     ".$rowBrowser['total_record']."],";
	}
	$browserChartStr=rtrim($browserChartStr,",");
	
	
}

?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});

google.charts.setOnLoadCallback(drawDeviceChart);
google.charts.setOnLoadCallback(drawOSChart);
google.charts.setOnLoadCallback(drawBrowserChart);

function drawDeviceChart() {
	var data = google.visualization.arrayToDataTable([
	  ['Device', 'Total Users'],
	  <?php echo $deviceChartStr?>	
	]);
	var options = {title: 'Device'};
	var chart = new google.visualization.PieChart(document.getElementById('device'));
	chart.draw(data, options);
}
function drawOSChart() {
	var data = google.visualization.arrayToDataTable([
	  ['OS', 'Total Users'],
	  <?php echo $osChartStr?>
	]);
	var options = {title: 'OS'};
	var chart = new google.visualization.PieChart(document.getElementById('os'));
	chart.draw(data, options);
}
function drawBrowserChart() {
	var data = google.visualization.arrayToDataTable([
	  ['Browser', 'Total Users'],
	  <?php echo $browserChartStr?>
	]);
	var options = {title: 'Browser'};
	var chart = new google.visualization.PieChart(document.getElementById('browser'));
	chart.draw(data, options);
}
</script>
<div class="page-wrapper">
<div class="page-breadcrumb">
   <div class="row align-items-center">
      <div class="col-md-6 col-8 align-self-center">
         <h3 class="page-title mb-0 p-0">QR Code Report</h3>
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="row">
	  <div class="col-6">
         <div class="card">
            <div class="card-body">
				<h2>Total Count</h2>
				<h3><?php echo $totalCount?></h3>
				<h4><a href="qr_detail_report.php?id=<?php echo $id?>">Details Report</a></h4>
			</div>
         </div>
      </div>	
      <div class="col-6">
         <div class="card">
            <div class="card-body" id="device"></div>
         </div>
      </div>
	  <div class="col-6">
         <div class="card">
            <div class="card-body" id="os"></div>
         </div>
      </div>
	  <div class="col-6">
         <div class="card">
            <div class="card-body" id="browser"></div>
         </div>
      </div>
	  <div class="col-12">
         <div class="card">
            <div class="card-body">
				<div class="table-responsive">
					<table class="table user-table">
						<thead>
							<tr>
								<th class="border-top-0">#</th>
								<th class="border-top-0">QR Code</th>
								<th class="border-top-0">Date</th>
								<th class="border-top-0">Count</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i=1;
							foreach($arr as $data){ ?>
							<tr>
								<td><?php echo $i++?></td>	
								<td><?php echo $data['name']?></td>
								<td><?php echo $data['added_on_str']?></td>
								<td><?php echo $data['total_record']?></td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
         </div>
      </div>
   </div>
</div>
<?php include('footer.php')?>