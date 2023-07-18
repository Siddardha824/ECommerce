<?php

    $cid = $_GET['cid'];

    include_once "../shared/authguard.php";

    if($utype != 'Customer')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "../shared/connection.php";

    $query = "delete from cartlist where cartid = $cid";

    $result = mysqli_query($conn,$query);
    if(! $result)
    {
        $err=mysqli_error($conn);
        header("location:cartremoveresult.php?res=0&err=$err");
    }
    else
    {
        header("location:cartremoveresult.php?res=1");
    }

?>