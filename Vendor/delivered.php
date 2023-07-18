<?php

    include_once "../shared/authguard.php";

    if($utype != 'Vendor')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "../shared/connection.php";

    $cid = $_GET['cid'];

    $query = "UPDATE cartlist SET OrderStatus = 2 WHERE cartlist.CartID = $cid";

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