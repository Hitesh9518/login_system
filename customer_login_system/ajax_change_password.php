<?php
require('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = array();

    $customer_email = $_POST['email'];
    
    //current password
    if (empty($_POST['current_password'])) {
            $error[] = "Current Password is Required";
        }else {
            $current_password = $_POST['current_password'];
        }
    //new password

    if (!empty($_POST['new_password']) && ($_POST["new_password"] == $_POST["confirm_password"])) {

        $new_password = $_POST['new_password'];

        if (!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/', $new_password)) {
            $error[] = "Password must contain minimum 8 characters of 1 digit, 1 capital and 1 lower";
        }
    } elseif (!empty($_POST["new_password"])) {
        $error[] = "New Password Or Confirm Password Not Match.!";
    } else {
        $error[] = "Please enter password";
    }

    $count = count($error);
    if ($count > 0) {
        foreach ($error as $value) {
            echo "<span class='error'>" . $value . "</span><br>";
        }
    } else {

        $OldPassword = "select customer_email,customer_password from customer_login where customer_email = '$customer_email'";
        $result = mysqli_query($con, $OldPassword);
        $row = mysqli_fetch_assoc($result);

        if ($current_password != $row['customer_password']) {
            echo "<span class='error'>Old Password does not match...!</span>";
        } else {
            if($current_password == $new_password){
                echo "<span class='error'>Current Password and New Password are Not Same...!</span>";
            }
            else{
                $update = "update customer_login set customer_password = '$new_password' where customer_email = '$customer_email'";

                $result = mysqli_query($con, $update);

                // echo "<span class='success'>Update Password...!</span>";

                if($result){
                    echo "<script>window.location.href='logout.php';</script>";
                }
            }
        }
    }
}
?>