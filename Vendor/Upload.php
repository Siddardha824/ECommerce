<?php

    include_once "../shared/authguard.php";

    if($utype != 'Vendor')
    {
        echo "Login Error. Please Re-login";
        die;
    }

    include_once "menu.html";

    echo '<div class="uploadcont">
            <form action="uploadproduct.php" class="upload" method="post" enctype="multipart/form-data">
                <div class="text-center text-light">
                    <h4>Upload Products</h4>
                </div>
                <input class="form-control mt-3" type="text" name="pname" placeholder="Enter Product Name">
                <input class="form-control mt-2" type="number" min="0" step="0.01" name="price" placeholder="Enter Price">
                <textarea class="form-control mt-2" name="details" cols="30" rows="10" placeholder="Details"></textarea>
                <input class="form-control mt-2" type="file" name="pimage">
                <button class="form-control mt-3 btn btn-success bagc">Upload</button>
            </form>
        </div>';

?>