<?php

    include_once "../shared/authguard.php";

    if($utype != 'Customer')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "menu.html";
    include_once "../shared/connection.php";

    $query = "select * from cartlist natural join products where CustomerID = $uid and OrderStatus = 0";
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
        $pid = $row['ProductID'];
        $name = $row['ProductName'];
        $impath = $row['ImagePath'];
        $details = $row['Details'];
        $price = $row['Price'];
        $cid = $row['CartID'];
        $total = $total + $price;
        echo "<div class='mycard'>
                <div class='imag'>
                    <img src='$impath'> 
                </div>
                <div class='pname'>$name</div>
                <div class='price'>₹$price</div>
                <div class='details'>$details</div>
                <div class = 'cent'>
                    <a class = 'btn btn-success bagc' href='placeorder.php?cid=$cid'>
                    Place Order
                    </a>
                </div>
                <div class = 'cent'>
                    <a class = 'btn btn-danger bagc' href='removefromcart.php?cid=$cid'>
                    Remove From Cart
                    </a>
                </div>
            </div>";
        
    }

    echo "</div>";

    if($total == 0)
    {
        echo "<h4 class = 'cen'>
                Your cart is empty.
            </h4>";
    }
    else
    {
        echo "<div class='porder d-flex'>
                <div class='placeorder'>Total Price: <span class='price placeorder'>₹$total</span></div>
                <a class = 'btn btn-success bagc' href = 'placeorder.php?uid=$uid'>Place Order</a>
            </div>";
    }

?>