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
                <div>Product Edited</div>";
} else {
    $err = $_GET['err'];
    echo "<div class='faile'>
                <div class='failtex'>Failed to Edit Product</div>
                <div class='failerr'>";
    echo $err;
    echo "</div>";
}
echo "  <div class='reslink'>
                <a class='btn btn-success bagc p-2 m-2' href='Upload.php'>Upload new Product</a>
                <a class='btn btn-success bagc p-2 m-2' href='home.php'>View Edited Product</a>
            </div>
        </div>";
