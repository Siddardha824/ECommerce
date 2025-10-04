<?php

include_once "../shared/authguard.php";

if ($utype != 'Vendor') {
    echo "Login Error. Please Re-login";
    die;
}

include_once "menu.html";
include_once "../shared/connection.php";

$pid = $_POST["pid"];
$pname = $_POST["pname"];
$price = $_POST["price"];
$details = $_POST["details"];

if (is_uploaded_file($_FILES["pimage"]["tmp_name"])) {
    $tempath = $_FILES["pimage"]["tmp_name"];
    date_default_timezone_set("Asia/Kolkata");
    $filename = "../shared/images/" . $uid . date("dMY_H_i_s") . ".jpg";
    move_uploaded_file($tempath, $filename);
    $query = "Update products set product_name = '$pname',img = '$filename',details = '$details',price = $price where product_id = $pid";
} else {
    $query = "Update products set product_name = '$pname',details = '$details',price = $price where product_id = $pid";
}

$result = mysqli_query($conn, $query);

if (! $result) {
    $err = mysqli_error($conn);
    header("location:editresult.php?res=0&err=$err");
} else {
    header("location:editresult.php?res=1");
}
