<?php
require('config.php');
error_reporting(0);
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $error = array();

    // customerfname
    if (empty($_POST['customer_fname'])) {

        $error[] = "First Name is Required";
    } else {
        $customer_fname = $_POST['customer_fname'];

        if (!preg_match("/^[a-zA-z]*$/", $customer_fname)) {
            $error[] = "Only alphabets and whitespace are allowed.";
        } else {
            $customer_fname = $_POST['customer_fname'];
        }
    }

    // customermname
    if (empty($_POST['customer_mname'])) {

        $error[] = "Middle Name is Required";
    } else {
        $customer_mname = $_POST['customer_mname'];

        if (!preg_match("/^[a-zA-z]*$/", $customer_mname)) {
            $error[] = "Only alphabets and whitespace are allowed.";
        } else {
            $customer_mname = $_POST['customer_mname'];
        }
    }

    // customerlname
    if (empty($_POST['customer_lname'])) {

        $error[] = "Last Name is Required";
    } else {
        $customer_lname = $_POST['customer_lname'];

        if (!preg_match("/^[a-zA-z]*$/", $customer_lname)) {
            $error[] = "Only alphabets and whitespace are allowed.";
        } else {
            $customer_lname = $_POST['customer_lname'];
        }
    }

    // dob
    if (empty($_POST['customer_dob'])) {
        $error[] = "DOB is Required";
    } else {
        $customer_dob = $_POST['customer_dob'];
    }

    // gender
    if (empty($_POST['customer_gender'])) {
        $error[] = "Gender is Required";
    } else {
        $customer_gender = $_POST['customer_gender'];
    }

    // hobbies
    if (empty($_POST['customer_hobbies'])) {
        $error[] = "Hobbies is Required";
    } else {
        $customer_hobbies = implode(",", $_POST['customer_hobbies']);
    }

    // address
    if (empty($_POST['customer_address'])) {
        $error[] = "Address is Required";
    } else {
        $customer_address = $_POST['customer_address'];
        if(empty(trim($customer_address))){
            $error[] = "Address is Required";
        }
    }
    // mobile
    if (empty($_POST['customer_mobile'])) {
        $error[] = "Mobile No is Required";
    } else {
        $customer_mobile = $_POST['customer_mobile'];

        if (!preg_match("/^[0-9]*$/", $customer_mobile)) {
            $error[] = "Only Numeric Value Allowed";
        }
        if (strlen($customer_mobile) != 10) {
            $error[] = "Mobile no must contain 10 digits";
        }
    }

    // email
    if (empty($_POST['customer_email'])) {
        $error[] = "Email is Required";
    } else {
        $customer_email = $_POST['customer_email'];

        if (!filter_var($customer_email, FILTER_VALIDATE_EMAIL)) {
            $error[] = "Invalid Email Format";
        }
    }

    // city
    if (empty($_POST['customer_city'])) {
        $error[] = "City is Required";
    } else {
        $customer_city = $_POST['customer_city'];
    }

    // state
    if (empty($_POST['customer_state'])) {
        $error[] = "State is Required";
    } else {
        $customer_state = $_POST['customer_state'];
    }

    // pincode
    if (empty($_POST['customer_pincode'])) {
        $error[] = "Pincode No is Required";
    } else {
        $customer_pincode = $_POST['customer_pincode'];

        if (!preg_match("/^[0-9]*$/", $customer_pincode)) {
            $error[] = "Only Numeric Value Allowed";
        }
        if (strlen($customer_pincode) != 6) {
            $error[] = "Pincode no must contain 6 digits";
        }
    }

    // password
    // if(empty($_POST['customer_password'])){
    //     $error[] = "Password is Reqired";
    // }else{
    //     $customer_password = $_POST['customer_password'];
        
    //     if(!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/',$customer_password)) {
    //         $error[] = "Password must contain minimum 8 characters of letters and numbers";
    //     }
    // }

    if(!empty($_POST['customer_password']) && ($_POST["customer_password"] == $_POST["customer_cpassword"])){
    
        $customer_password = $_POST['customer_password'];
        
        if(!preg_match('/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[A-Za-z])[0-9A-Za-z]{8,}$/',$customer_password)) {
            $error[] = "Password must contain minimum 8 characters of 1 digit, 1 capital and 1 lower";
        }
    }elseif(!empty($_POST["customer_password"])) {
        $error[] = "Password Or Confirm Password Not Match.!";
    } else {
         $error[] = "Please enter password";
    }

    // // confirm password
    // if (empty($_POST['customer_cpassword'])) {
    //     $error[] = "Confirm Password is Required";
    // }else {
    //     $customer_cpassword = $_POST['customer_cpassword'];
    // }

    $count = count($error);
    if ($count > 0) {
        foreach ($error as $value) {
            echo "<span class='error'>" . $value . "</span><br>";
        }
    } 
    else {
        $checkEmail = "select * from customer_login where customer_email = '$customer_email'";
        $result = mysqli_query($con,$checkEmail);
        $row = mysqli_fetch_array($result,MYSQLI_NUM);

        if($row[0] > 0){
            echo "<span class='error'>Email Already Exist...!</span>";
        exit();
        }else{

            $insert = "insert into customer_login values (NULL,'$customer_fname','$customer_mname','$customer_lname','$customer_dob','$customer_gender','$customer_hobbies','$customer_address','$customer_mobile','$customer_email','$customer_city','$customer_state','$customer_pincode','$customer_password','');";
            $result = mysqli_query($con, $insert);

            // echo "<span class='success'>Data Inserted...!</span>"; 
            
            if($result){
                echo "<script>window.location.href='index.php';</script>";
            }
        }
    }
}
?>