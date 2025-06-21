<?php
    include_once "../config.php";
    $conn = new mysqli ($database["host"],$database_user["username"],$database_user["password"],$database["database_name"],$database["port"]);
    if ($conn -> connect_error)
    {
        echo "Error in MySQL Connection";
        die;
    }

?>