<?php

    include_once "../shared/authguard.php";

    if($utype != 'Customer')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "menu.html";

    $res = $_GET['res'];
    if ($res == 1)
    {
        echo "<div class='succe'>
                <div>Product Added to Cart</div>";
    }
    else
    {
        $err = $_GET['err'];
        echo "<div class='faile'>
                <div class='failtex'>Failed to add Product to Cart</div>
                <div class='failerr'>";
        echo $err;
        echo "</div>";
    }
    echo "  <div class='reslink'>
                <a class='btn btn-success bagc p-2 m-2' href='cart.php'>Go to my Cart</a>
                <a class='btn btn-success bagc p-2 m-2' href='home.php'>Explore other Products</a>
            </div>
        </div>";

?>