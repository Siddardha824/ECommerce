<?php

    $conn = new mysqli ("localhost","root","","webdev");
    if ($conn -> connect_error)
    {
        echo "Error in Connection";
        die;
    }

?>