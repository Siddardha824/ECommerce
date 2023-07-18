<?php

    include_once "../shared/authguard.php";

    if($utype != 'Customer')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    $cid = $_GET['cid'];

    include_once "../shared/connection.php";

    $query = "update cartlist set OrderStatus = 3 where cartid = $cid";

    $result = mysqli_query($conn,$query);
    if(! $result)
    {
        $err=mysqli_error($conn);
        header("location:cancelresult.php?res=0&err=$err");
    }
    else
    {
        header("location:cancelresult.php?res=1");
    }

?>