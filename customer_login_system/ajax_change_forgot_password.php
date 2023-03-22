<?php
require('config.php');
error_reporting(0);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = array();

    // otp
    if (empty($_POST['otp'])) {
        $error[] = "OTP is Reqired";
    } else {
        $token = $_POST['otp'];
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
        $checkOTP = "select * from customer_login where token = '$token'";
        $result = mysqli_query($con, $checkOTP);
        $row = mysqli_fetch_assoc($result);

        if ($token != $row['token']) {
            echo "<span class='error'>Wrong OTP...!</span>";
        } else {

            $update = "update customer_login set customer_password = '$new_password' where customer_email = '$row[customer_email]'";

            $result = mysqli_query($con, $update);

            echo "<span class='success'>Update Password...!</span>";
            if ($result) {
                $update2 = "update customer_login set token='' where token = '$token'";
                $result = mysqli_query($con, $update2);

                echo "<script>window.location.href='index.php';</script>";
            }
        }
    }
}
?>