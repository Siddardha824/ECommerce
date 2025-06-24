<?php

    include_once "../shared/authguard.php";

    if($utype != 'Customer')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    $pid = $_GET['pid'];

    include_once "../shared/connection.php";

    $query = "insert into cart(user_id,product_id) values($uid,$pid)";

    $result = mysqli_query($conn,$query);
    if(! $result)
    {
        $err=mysqli_error($conn);
        header("location:cartresult.php?res=0&err=$err");
    }
    else
    {
        header("location:cartresult.php?res=1");
    }

?>