<?php
include('header.php');
check_auth();

if (isset($_GET['id']) && $_GET['id'] > 0) {
    $id = get_safe_value($_GET['id']);
    $condition = "";

    // Check if the logged-in user is an admin
    if ($_SESSION['QR_USER_ROLE'] == 1) {
        $condition = " and added_by='" . $_SESSION['QR_USER_ID'] . "'";
    }

    // Delete the QR code from the database
    mysqli_query($con, "DELETE FROM qr_code WHERE id='$id' $condition");

    // Redirect back to the QR codes page
    redirect('qr_codes.php');
} else {
    redirect('qr_codes.php');
}
?>
