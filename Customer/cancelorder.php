<?php

include_once "../shared/authguard.php";

if ($utype != 'Customer') {
    echo "Login Error. Please Re-login";
    die;
}

$oid = $_GET['oid'];

include_once "../shared/connection.php";

$query = "update orders set status = 'Canceled' where order_id = $oid";

$result = mysqli_query($conn, $query);
if (! $result) {
    $err = mysqli_error($conn);
    header("location:cancelresult.php?res=0&err=$err");
} else {
    header("location:cancelresult.php?res=1");
}
