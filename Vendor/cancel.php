<?php

    include_once "../shared/authguard.php";

    if($utype != 'Vendor')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    $oid = $_GET['oid'];

    include_once "../shared/connection.php";

    $query = "Update orders set status = `Canceled` where order_id = $oid";

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