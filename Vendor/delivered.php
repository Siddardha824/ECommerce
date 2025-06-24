<?php

    include_once "../shared/authguard.php";

    if($utype != 'Vendor')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "../shared/connection.php";

    $oid = $_GET['oid'];

    $query = "UPDATE orders SET status = `Delivered` WHERE order_id = $oid";

    $result = mysqli_query($conn,$query);
    if(! $result)
    {
        $err=mysqli_error($conn);
        header("location:deliveredresult.php?res=0&err=$err");
    }
    else
    {
        header("location:deliveredresult.php?res=1");
    }

?>