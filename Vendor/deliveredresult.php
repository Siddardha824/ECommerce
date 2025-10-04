<?php

include_once "../shared/authguard.php";

if ($utype != 'Vendor') {
    echo "Login Error. Please Re-login";
    die;
}

include_once "menu.html";

$res = $_GET['res'];
if ($res == 1) {
    echo "<div class='succe'>
                <div>Order Marked As Delivered</div>";
} else {
    $err = $_GET['err'];
    echo "<div class='faile'>
                <div class='failtex'>Failed to Mark Order Delivered</div>
                <div class='failerr'>";
    echo $err;
    echo "</div>";
}
echo "  <div>
                <a class='btn btn-success bagc' href='View.php'>Back to Orders</a>
            </div>
        </div>";
