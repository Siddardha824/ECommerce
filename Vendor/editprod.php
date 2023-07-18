<?php

    include_once "../shared/authguard.php";

    if($utype != 'Vendor')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "menu.html";
    include_once "../shared/connection.php";

    $pid = $_GET["pid"];
    $query = "select * from products where productid = $pid";
    $result=mysqli_query($conn,$query);
    if(! $result)
    {
        echo "Connection Error";
        echo mysqli_error($conn);
        die;
    }

    $row = mysqli_fetch_assoc($result);
    $name = $row['ProductName'];
    $impath = $row['ImagePath'];
    $details = $row['Details'];
    $price = $row['Price'];

    echo '<div class="uploadcont">
            <form action="editproduct.php" class="upload" method="post" enctype="multipart/form-data">
                <div class="text-center text-light">
                    <h4>Edit Product</h4>
                </div>
                <input style="display: none;" type="number" name="pid" id="pid">
                <input id="name" class="form-control mt-3" type="text" name="pname" placeholder="Enter Product Name">
                <input id="price" class="form-control mt-2" type="number" min="0" step="0.01" name="price" placeholder="Enter Price">
                <textarea id="details" class="form-control mt-2" name="details" cols="30" rows="10" placeholder="Details"></textarea>
                <input id="imag" class="form-control mt-2" type="file" name="pimage">
                <div style="color: white;">(Leave Blank To keep same image)</div>
                <button class="form-control mt-3 btn btn-success bagc">Submit</button>
            </form>
        </div>
        
        <script>
            nameobj = document.getElementById("name");
            nameobj.value = "'.$name.'";
            priceobj = document.getElementById("price");
            priceobj.value = '.$price.';
            idobj = document.getElementById("pid");
            idobj.value = '.$pid.';
            detailobj = document.getElementById("details");
            detailobj.value = "'.$details.'";
        </script>
        
        ';

?>