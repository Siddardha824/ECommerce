<?php

    include_once "../shared/authguard.php";

    if($utype != 'Vendor')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "../shared/connection.php";

    $pid = $_GET['pid'];

    $query = "delete FROM Products WHERE product_id = $pid";
    $result1 = mysqli_query($conn,$query);
    $query = "delete FROM cartlist WHERE product_id = $pid";
    $result2 = mysqli_query($conn,$query);
    if(! ($result1 & $result2))
    {
        $err=mysqli_error($conn);
        header("location:deleteresult.php?res=0&err=$err");
    }
    else
    {
        header("location:deleteresult.php?res=1");
    }

?>