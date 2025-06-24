<?php

    include_once "../shared/authguard.php";

    if($utype != 'Customer')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "menu.html";
    include_once "../shared/connection.php";

    $query = "select * from cartlist natural join products where CustomerID = $uid and (OrderStatus = 1 or OrderStatus = 2 or OrderStatus = 3)";
    $result = mysqli_query($conn,$query);

    if(! $result)
    {
        echo "Connection Error";
        echo mysqli_error($conn);
    }

    echo "<div class='containe'>";

    $total = 0;

    while ($row = mysqli_fetch_assoc($result))
    {
        $pid = $row['product_id'];
        $name = $row['product_name'];
        $impath = $row['img'];
        $details = $row['details'];
        $price = $row['price'];
        $cid = $row['CartID'];
        $total = $total + $price;

        if ($row['OrderStatus'] == 1)
        {
            echo "<div class='mycard'>
                <div class='imag'>
                    <img src='$impath'> 
                </div>
                <div class='pname'>$name</div>
                <div class='price'>₹$price</div>
                <div class='details'>$details</div>
                <div class = 'cent'>
                    <a class = 'btn btn-danger bagc' href='cancelorder.php?cid=$cid'>
                    Cancel Order
                    </a>
                </div>
            </div>";
        }
        elseif ($row['OrderStatus'] == 2)
        {
            echo "<div class='mycard'>
                <div class='imag'>
                    <img src='$impath'> 
                </div>
                <div class='pname'>$name</div>
                <div class='price'>₹$price</div>
                <div class='details'>$details</div>
                <div class='cent' style='font-weight: bold; color: green;'>Order Delivered</div>
            </div>";
        }
        else
        {
            echo "<div class='mycard'>
                <div class='imag'>
                    <img src='$impath'> 
                </div>
                <div class='pname'>$name</div>
                <div class='price'>₹$price</div>
                <div class='details'>$details</div>
                <div class='cent' style='font-weight: bold; color: red;'>Order Cancelled</div>
            </div>";
        }
    }

    echo "</div>";

    if($total == 0)
    {
        echo "<h4 class = 'cen'>
                You did not place any Orders.
            </h4>";
    }

?>