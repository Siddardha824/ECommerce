<?php

    include_once "../DatabaseScripts/config.php";
    $db_connection = new mysqli ($database["host"],$database_user["username"],$database_user["password"],$database["database_name"],$database["port"]);
    if ($db_connection -> connect_error)
    {
        echo "Error in MySQL Connection";
        die;
    }

?>