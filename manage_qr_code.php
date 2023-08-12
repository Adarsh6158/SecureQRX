<?php 
include('header.php');
check_auth();
$msg="";
$name="";
$link="";
$color="";
$size="";
$id=0;
$condition="";
$isAdmin='yes';
if($_SESSION['QR_USER_ROLE']==1){
	$condition=" and added_by='".$_SESSION['QR_USER_ID']."'";
	
	$getUserInfo=getUserInfo($_SESSION['QR_USER_ID']);
	$getUserTotalQR=getUserTotalQR($_SESSION['QR_USER_ID']);
	
	$isAdmin="no";
}
$password_required="required";
if(isset($_GET['id']) && $_GET['id']>0){
	$id=get_safe_value($_GET['id']);
	$res=mysqli_query($con,"select * from qr_code where id='$id' $condition");
	if(mysqli_num_rows($res)>0){
		$row=mysqli_fetch_assoc($res);
		$name=$row['name'];
		$link=$row['link'];
		$color=$row['color'];
		$size=$row['size'];
	}else{
		redirect('users.php');	
	}
}

if(isset($_POST['submit'])){
	$name=get_safe_value($_POST['name']);
	$link=get_safe_value($_POST['link']);
	$color=get_safe_value($_POST['color']);
	$size=get_safe_value($_POST['size']);
	$added_by=$_SESSION['QR_USER_ID'];
	$status=1;
	$added_on=date('Y-m-d h:i:s');
	
	if($id>0){
		mysqli_query($con,"update qr_code set name='$name',link='$link',color='$color',size='$size' where id='$id' $condition");
	}else{
		mysqli_query($con,"insert into qr_code(name,link,color,size,added_by,status,added_on) values('$name','$link','$color','$size','$added_by','$status','$added_on')");	
	}
	redirect('qr_codes.php');	
}
?>
<div class="page-wrapper">
<div class="page-breadcrumb">
   <div class="row align-items-center">
      <div class="col-md-6 col-8 align-self-center">
         <h3 class="page-title mb-0 p-0">Manage QR Code</h3>
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
                         <input type="name" placeholder="Enter Name" class="form-control pl-0 form-control-line" name="name"  required value="<?php echo $name?>">
                     </div>
                  </div>
                  <div class="form-group">
                     <label for="example-email" class="col-md-12">Link</label>
                     <div class="col-md-12">
                        <input type="text" placeholder="Link" class="form-control pl-0 form-control-line" name="link" required  value="<?php echo $link?>">
                     </div>
                  </div>
				  <div class="form-group">
    <label for="example-email" class="col-md-12">Color</label>
    <div class="col-md-12">
        <select name="color" required class="form-control pl-0 form-control-line">
            <option value="">Select Color</option>
            <?php
            $colorSql = mysqli_query($con, "select * from color where status=1 order by color asc");
          
            $colorNames = array(
                'FFFFFF' => 'White',
                'ff0000' => 'Red',
                '1ab2ff' => 'Blue',
				'00ff00' => 'Green',
                'ffff00' => 'Yellow',
                'ffa500' => 'Orange',
                'ff00ff' => 'Magenta',
            );

            while ($colorRow = mysqli_fetch_assoc($colorSql)) {
                $is_selected = "";
                if ($colorRow['color'] == $color) {
                    $is_selected = "selected";
                }

               
                $colorName = isset($colorNames[$colorRow['color']]) ? $colorNames[$colorRow['color']] : '';

                echo '<option value="' . $colorRow['color'] . '" ' . $is_selected . '>' . $colorName . '</option>';
            }
            ?>
        </select>
    </div>
</div>

				  <div class="form-group">
                     <label for="example-email" class="col-md-12">Size</label>
                     <div class="col-md-12">
						<select name="size" required class="form-control pl-0 form-control-line">
						<option value="">Select Size</option>
						<?php
						$sizeSql=mysqli_query($con,"select * from size where status=1 order by size asc");
						while($sizeRow=mysqli_fetch_assoc($sizeSql)){
							$is_selected="";
							if($sizeRow['size']==$size){
								$is_selected="selected";
							}
							echo '<option value="'.$sizeRow['size'].'" '.$is_selected.'>'.$sizeRow['size'].'</option>';
						}
						?>
						</select>
                     </div>
                  </div>
				  
                  <div class="form-group">
                     <div class="col-sm-12 d-flex">
                        <?php
						if($id==0 && $isAdmin=="no"){
							if($getUserInfo['total_qr']>$getUserTotalQR['total_qr']){
								?>
								<button class="btn btn-success mx-auto mx-md-0 text-white" name="submit">Submit</button>
								<?php
							}else{
								echo "<span style='color:red'>Total QR Code Limit Completed</span>";
							}
						}else{
							?>
							<button class="btn btn-success mx-auto mx-md-0 text-white" name="submit">Submit</button>
							<?php
						}
						?>
						
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?php include('footer.php')?>