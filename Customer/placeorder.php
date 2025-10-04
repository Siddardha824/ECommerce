<?php

include_once "../shared/authguard.php";

if ($utype != 'Customer') {
    echo "Login Error. Please Re-login";
    die;
}

include_once "../shared/connection.php";

$pid = $_GET['pid'];

$query = "insert into orders(user_id,product_id,status) values($uid,$pid,'Ordered')";

$result = mysqli_query($conn, $query);
if (! $result) {
    $err = mysqli_error($conn);
    header("location:orderresult.php?res=0&err=$err");
} else {
    header("location:orderresult.php?res=1");
}
