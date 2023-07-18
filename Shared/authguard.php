<?php

    session_start();

    if(! isset($_SESSION['status']))
    {
        echo "Unathorized access";
        die;
    }

    if($_SESSION['status'] == false)
    {
        echo "Login Error. Please Re-login";
        die;
    }

    $uname = $_SESSION['uname'];
    $uid = $_SESSION['uid'];
    $utype = $_SESSION['utype'];

?>