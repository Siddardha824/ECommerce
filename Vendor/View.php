<?php

    include_once "../shared/authguard.php";

    if($utype != 'Vendor')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    // include_once "menu.html";
    include_once "../DatabaseScripts/accessDatabase.php";

    echo getOrders($uid);

    // $query = "select * from (orders join products on orders.product_id = products.product_id) join users on orders.user_id = users.user_id where products.user_id = $uid";
    // $result = mysqli_query($conn,$query);

    // if(! $result)
    // {
    //     echo "Connection Error";
    //     echo mysqli_error($conn);
    // }

    // echo "<div class='containe'>";

    // $total = 0;

    // while ($row = mysqli_fetch_assoc($result))
    // {
    //     $pid = $row['product_id'];
    //     $name = $row['product_name'];
    //     $impath = $row['img'];
    //     $details = $row['details'];
    //     $price = $row['price'];
    //     $oid = $row['order_id'];
    //     $uname = $row['user_name'];
    //     $total = $total + $price;

    //     if ($row['status'] ==  "Ordered" || $row['status'] == "In Transit")
    //     {
    //         echo "<div class='mycard'>
    //             <div class='imag'>
    //                 <img src='$impath'> 
    //             </div>
    //             <div class='pname'>$name</div>
    //             <div class='price'>₹$price</div>
    //             <div class='ordedby'>Ordered By $uname</div>
    //             <div class='details'>$details</div>
    //             <div class = 'cent'>
    //                 <a class = 'btn btn-success bagc' href='delivered.php?oid=$oid'>
    //                 Mark as Delivered
    //                 </a>
    //             </div>
    //             <div class = 'cent'>
    //                 <a class = 'btn btn-danger bagc' href='cancel.php?oid=$oid'>
    //                 Cancel Order
    //                 </a>
    //             </div>
    //         </div>";
    //     }
    //     elseif ($row['status'] ==  "Delivered")
    //     {
    //         echo "<div class='mycard'>
    //             <div class='imag'>
    //                 <img src='$impath'> 
    //             </div>
    //             <div class='pname'>$name</div>
    //             <div class='price'>₹$price</div>
    //             <div class='ordedby'>Ordered By $uname</div>
    //             <div class='details'>$details</div>
    //             <div class='cent' style='font-weight: bold; color: green;'>Order Delivered</div>
    //         </div>";
    //     }
    //     else
    //     {
    //         echo "<div class='mycard'>
    //             <div class='imag'>
    //                 <img src='$impath'> 
    //             </div>
    //             <div class='pname'>$name</div>
    //             <div class='price'>₹$price</div>
    //             <div class='ordedby'>Ordered By $uname</div>
    //             <div class='details'>$details</div>
    //             <div class='cent' style='font-weight: bold; color: red;'>Order Cancelled</div>
    //         </div>";
    //     }
    // }

    // echo "</div>";

    // if($total == 0)
    // {
    //     echo "<h4 class = 'cen'>
    //             You do not have any Orders.
    //         </h4>";
    // }

?>