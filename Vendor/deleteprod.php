<?php

    include_once "../shared/authguard.php";

    if($utype != 'Vendor')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "../shared/connection.php";

    $pid = $_GET['pid'];
    $query = "select img from Products where product_id = $pid";
    $result = mysqli_query($conn, $query);
    if(!$result)
    {
        $err = mysqli_error($conn);
        header("location:deleteresult.php?res=0&err=$err");
        die;
    }
    $row = mysqli_fetch_assoc($result);
    if($row)
    {
        $img = $row['img'];
        if($img != null && $img != "")
        {
            if(file_exists($img))
            {
                unlink($img);
            }
        }
    }
    $query = "delete FROM Products WHERE product_id = $pid";
    $result1 = mysqli_query($conn,$query);
    if(! $result1)
    {
        $err=mysqli_error($conn);
        header("location:deleteresult.php?res=0&err=$err");
    }
    else
    {
        header("location:deleteresult.php?res=1");
    }

?>