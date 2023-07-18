<?php

    include_once "../shared/authguard.php";

    if($utype != 'Customer')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "menu.html";
    include_once "../shared/connection.php";

    $query = "select * from products";
    $result = mysqli_query($conn,$query);

    if(! $result)
    {
        echo "Connection Error";
        echo mysqli_error($conn);
    }

    if(mysqli_num_rows($result) == 0)
    {
        echo "<h4 class='cen'>There are no products to View.</h4>";
    }
    else
    {
        echo "<div class='containe'>";

        while ($row = mysqli_fetch_assoc($result))
        {
            $pid = $row['ProductID'];
            $name = $row['ProductName'];
            $impath = $row['ImagePath'];
            $details = $row['Details'];
            $price = $row['Price'];

            echo "<div class='mycard'>
                    <div class='imag'>
                        <img src='$impath'> 
                    </div>
                    <div class='pname'>$name</div>
                    <div class='price'>₹$price</div>
                    <div class='details'>$details</div>
                    <div class = 'cent'>
                        <a class = 'btn btn-success bagc' href='addtocart.php?pid=$pid'>
                        Add To Cart
                        </a>
                    </div>
                    <div class = 'cent'>
                        <a class = 'btn btn-success bagc' href='placeorder.php?pid=$pid'>
                        Place Order
                        </a>
                    </div>
                </div>";
        }
    }

    echo "</div>";

?>