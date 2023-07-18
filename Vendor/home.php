<?php

    include_once "../shared/authguard.php";

    if($utype != 'Vendor')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "menu.html";
    include_once "../shared/connection.php";

    $query = "select * from products where UploadedBy = $uid";
    $result = mysqli_query($conn,$query);

    if(! $result)
    {
        echo "Connection Error";
        echo mysqli_error($conn);
    }

    if(mysqli_num_rows($result) == 0)
    {
        echo "<h4 class='cen'>You did not Upload any Products.</h4>";
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
                        <a class = 'btn btn-warning bagc' href='editprod.php?pid=$pid'>
                        Edit Product Info
                        </a>
                    </div>
                    <div class = 'cent'>
                        <a class = 'btn btn-danger bagc' href='deleteprod.php?pid=$pid'>
                        Delete
                        </a>
                    </div>
                </div>";
            
        }
    }

    echo "</div>";

?>