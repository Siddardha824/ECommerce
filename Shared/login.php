<?php

    session_start();
    $_SESSION['status'] = false;

    $uname = $_POST["uname"];
    $upass = $_POST["upass"];

    include_once "connection.php";

    $check =  mysqli_query($conn,"Select * from users where User_Name = '$uname' and Password = '$upass'");

    if(! $check)
    {
        echo "Login Failed";
        echo mysqli_error($conn);
        die;
    }

    if($check->num_rows == 0)
    {
        echo "Incorrect Credentials";
        die;
    }

    $row = mysqli_fetch_assoc($check);

    $_SESSION['status'] = true;
    $_SESSION['uname'] = $row['User_Name'];
    $_SESSION['uid'] = $row['UserID'];
    $_SESSION['utype'] = $row['UserType'];

    if($row['UserType'] == 'Vendor')
    {
        header("location:../Vendor/home.php");
    }
    else
    {
        header("location:../Customer/home.php");
    }

?>