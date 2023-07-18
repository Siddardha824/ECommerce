<?php

    include_once "../shared/authguard.php";

    if($utype != 'Customer')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "../shared/connection.php";

    if(isset($_GET['cid']))
    {
        $cid = $_GET['cid'];

        $query = "UPDATE cartlist SET OrderStatus = 1 WHERE cartlist.CartID = $cid";

        $result = mysqli_query($conn,$query);
        if(! $result)
        {
            $err=mysqli_error($conn);
            header("location:orderresult.php?res=0&err=$err");
        }
        else
        {
            header("location:orderresult.php?res=1");
        }
    }

    if(isset($_GET['pid']))
    {
        $pid = $_GET['pid'];

        $query = "insert into cartlist(CustomerID,ProductID,OrderStatus) values($uid,$pid,1)";

        $result = mysqli_query($conn,$query);
        if(! $result)
        {
            $err=mysqli_error($conn);
            header("location:orderresult.php?res=0&err=$err");
        }
        else
        {
            header("location:orderresult.php?res=1");
        }
    }

    if(isset($_GET['uid']))
    {
        $uid = $_GET['uid'];

        $query = "update cartlist set orderstatus=1 where customerid=$uid";

        $result = mysqli_query($conn,$query);
        if(! $result)
        {
            $err=mysqli_error($conn);
            header("location:orderresult.php?res=0&err=$err");
        }
        else
        {
            header("location:orderresult.php?res=1");
        }
    }

?>