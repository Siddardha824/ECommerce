<?php

    include_once "../shared/authguard.php";

    if($utype != 'Vendor')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    $cid = $_GET['cid'];

    include_once "../shared/connection.php";

    $query = "Update cartlist set OrderStatus = 3 where cartid = $cid";

    $result = mysqli_query($conn,$query);
    if($result)
    {
        header("location:cancelresult.php?res=1");
    }
    else
    {
        $err=mysqli_error($conn);
        header("location:cancelresult.php?res=0&err=$err");
    }

?>