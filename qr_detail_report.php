<?php 
include('header.php');
check_auth();

if(isset($_GET['id']) && $_GET['id']>0){
	
	$condition="";
	if($_SESSION['QR_USER_ROLE']==1){
		$condition=" and qr_code.added_by='".$_SESSION['QR_USER_ID']."'";
	}
	
	$id=get_safe_value($_GET['id']);
	
	$res=mysqli_query($con,"select qr_traffic.*,qr_code.name from qr_traffic,qr_code where qr_traffic.qr_code_id=qr_code.id and qr_code.id='$id' $condition");
	if(mysqli_num_rows($res)>0){
		while($row=mysqli_fetch_assoc($res)){
			$arr[]=$row;
		}	
	}else{
		redirect('qr_codes.php');
	}
	
}
?>

<div class="page-wrapper">
<div class="page-breadcrumb">
   <div class="row align-items-center">
      <div class="col-md-6 col-8 align-self-center">
         <h3 class="page-title mb-0 p-0">QR Code Report</h3>
		 <a href="qr_report.php?id=<?php echo $id?>">Back</a>
      </div>
   </div>
</div>
<div class="container-fluid">
   <div class="row">
	  <div class="col-12">
         <div class="card">
            <div class="card-body">
				<div class="table-responsive">
					<table class="table user-table">
						<thead>
							<tr>
								<th class="border-top-0">#</th>
								<th class="border-top-0">Device</th>
								<th class="border-top-0">OS</th>
								<th class="border-top-0">Browser</th>
								<th class="border-top-0">City</th>
								<th class="border-top-0">State</th>
								<th class="border-top-0">Country</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i=1;
							foreach($arr as $data){ ?>
							<tr>
								<td><?php echo $i++?></td>	
								<td><?php echo $data['device']?></td>
								<td><?php echo $data['os']?></td>
								<td><?php echo $data['browser']?></td>
								<td><?php echo $data['city']?></td>
								<td><?php echo $data['state']?></td>
								<td><?php echo $data['country']?></td>
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