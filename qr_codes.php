<?php 
ob_start(); // Start output buffering

include('header.php');
check_auth();

$condition="";
if($_SESSION['QR_USER_ROLE']==1){
    $condition=" and added_by='".$_SESSION['QR_USER_ID']."'";
}

if(isset($_GET['type']) && $_GET['type']=='download'){
    $link="https://chart.apis.google.com/chart?cht=qr&chs=".$_GET['chs']."&chco=".$_GET['chco']."&chl=".$_GET['chl'];
    ob_clean(); // Clear output buffer
    header('Content-type: application/x-file-to-save');
    header('Content-Disposition: attachment;filename='.time().'.jpg');
    readfile($link);
    exit(); // Terminate the script after sending the file
}

if(isset($_GET['status']) && $_GET['status']!='' && isset($_GET['id']) && $_GET['id']>0){
    $status=get_safe_value($_GET['status']);
    $id=get_safe_value($_GET['id']);

    if($status=="active"){
        $status=1;
    }else{
        $status=0;
    }

    mysqli_query($con,"update qr_code set status='$status' where id='$id' $condition");
    redirect('qr_codes.php');
}

$res=mysqli_query($con,"select qr_code.*,users.email from qr_code,users where 1 and qr_code.added_by=users.id  $condition order by qr_code.added_on desc");
?>
<div class="page-wrapper">
<div class="page-breadcrumb">
    <div class="row align-items-center">
        <div class="col-md-6 col-8 align-self-center">
        <h3 class="mb-0 p-0">QR Codes</h3>
        </div>
        <div class="col-md-6 col-4 text-end">
            <a href="manage_qr_code.php" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i>
                Add New QR Code
            </a>
        </div>
    </div>
</div>

	
			<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <?php if(mysqli_num_rows($res) > 0) { ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover user-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>QR Code</th>
                                        <th>Link</th>
                                        <th>Added On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $i = 1;
                                    while($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $i++; ?></td>
                                        <td>
                                            <?php echo $row['name']; ?><br/>
                                            <?php if($_SESSION['QR_USER_ROLE'] == 0) { ?>
                                                Added By: <b><?php echo $row['email']; ?></b><br/>
                                            <?php } ?>
                                            <a href="qr_report.php?id=<?php echo $row['id']; ?>">Report</a>
                                        </td>
                                        <td style="text-align:center; vertical-align: middle;">
                                            <a target="_blank" href="https://chart.apis.google.com/chart?cht=qr&chs=<?php echo $row['size']; ?>&chco=<?php echo $row['color']; ?>&chl=<?php echo $qr_file_path; ?>?id=<?php echo $row['id']; ?>">
                                                <img src="https://chart.apis.google.com/chart?cht=qr&chs=<?php echo $row['size']; ?>&chco=<?php echo $row['color']; ?>&chl=<?php echo $qr_file_path; ?>?id=<?php echo $row['id']; ?>" width="100px"/>
                                            </a>
                                            <br/>
                                            <b><a href="?type=download&chs=<?php echo $row['size']; ?>&chco=<?php echo $row['color']; ?>&chl=<?php echo $qr_file_path; ?>?id=<?php echo $row['id']; ?>">Download</a></b>
                                        </td>
                                        <td><?php echo $row['link']; ?></td>
                                        <td><?php echo getCustomDate($row['added_on']); ?></td>
                                        <td>
										<div class="d-flex align-items-center">
                                            <a href="manage_qr_code.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm mr-2">Edit</a>
                                            <a href="delete_qr_code.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm mr-2">Delete</a>  
                                            <?php    
                                            $status = "active";
                                            $strStatus = "Deactive";
                                            if($row['status'] == 1){
                                                $status = "deactive";
                                                $strStatus = "Active";
                                            }
                                            ?>
                                            <a href="?id=<?php echo $row['id']; ?>&status=<?php echo $status; ?>" class="btn btn-<?php echo ($row['status'] == 1) ? 'success' : 'warning'; ?> btn-sm"><?php echo $strStatus; ?></a>
											</div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    <?php } else { ?>
                        <p>No data found</p>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('footer.php')?>