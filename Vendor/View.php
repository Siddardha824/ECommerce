<?php

    include_once "../shared/authguard.php";

    if($utype != 'Vendor')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "menu.html";
    include_once "../shared/connection.php";

    $query = "select * from (cartlist natural join products) join users where (cartlist.customerid = users.userid) and (UploadedBy = $uid and (OrderStatus = 1 or OrderStatus = 2 or OrderStatus = 3))";
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
        $uname = $row['user_name'];
        $total = $total + $price;

        if ($row['OrderStatus'] == 1)
        {
            echo "<div class='mycard'>
                <div class='imag'>
                    <img src='$impath'> 
                </div>
                <div class='pname'>$name</div>
                <div class='price'>₹$price</div>
                <div class='ordedby'>Ordered By $uname</div>
                <div class='details'>$details</div>
                <div class = 'cent'>
                    <a class = 'btn btn-success bagc' href='delivered.php?cid=$cid'>
                    Mark as Delivered
                    </a>
                </div>
                <div class = 'cent'>
                    <a class = 'btn btn-danger bagc' href='cancel.php?cid=$cid'>
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
                <div class='ordedby'>Ordered By $uname</div>
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
                <div class='ordedby'>Ordered By $uname</div>
                <div class='details'>$details</div>
                <div class='cent' style='font-weight: bold; color: red;'>Order Cancelled</div>
            </div>";
        }
    }

    echo "</div>";

    if($total == 0)
    {
        echo "<h4 class = 'cen'>
                You do not have any Orders.
            </h4>";
    }

?>