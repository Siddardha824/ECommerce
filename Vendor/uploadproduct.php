<?php

include_once "../shared/authguard.php";

if ($utype != 'Vendor') {
    echo "Login Error. Please Re-login";
    die;
}

include_once "menu.html";
include_once "../shared/connection.php";

$pname = $_POST["pname"];
$price = $_POST["price"];
$details = $_POST["details"];

$tempath = $_FILES["pimage"]["tmp_name"];
date_default_timezone_set("Asia/Kolkata");
$filename = "../shared/images/" . $uid . date("dMY_H_i_s") . ".jpg";
move_uploaded_file($tempath, $filename);

$query = "Insert into products(product_name,img,user_id,details,price) values('$pname','$filename',$uid,'$details',$price)";

$result = mysqli_query($conn, $query);

if (! $result) {
    $err = mysqli_error($conn);
    header("location:uploadresult.php?res=0&err=$err");
} else {
    header("location:uploadresult.php?res=1");
}
