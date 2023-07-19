<?php
include('header.php');
check_auth();
check_admin_auth();

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    mysqli_query($con, "DELETE FROM users WHERE id='$id'");
    redirect('users.php');
} else {
    redirect('users.php');
}
?>
