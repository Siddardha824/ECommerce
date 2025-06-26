<?php

    include_once "../DatabaseScripts/accessDatabase.php";

    session_start();
    header('Content-Type: application/json');

    $_SESSION['status'] = false;

    $uname = $_POST["uname"] ?? '';
    $upass = $_POST["upass"] ?? '';

    if (empty($uname) || empty($upass)) {
        echo replyMsg("Username and password are required.", false, 400);
        exit;
    }

    $result = json_decode(verifyLoginCredentials($uname, $upass), true);

    if (!$result["success"]) {
        echo json_encode($result);
        exit;
    }
    $result = json_decode($result["message"], true);
    // Set session variables
    $_SESSION['status'] = true;
    $_SESSION['uname'] = $result["user_name"];
    $_SESSION['uid'] = $result["user_id"];
    $_SESSION['utype'] = $result["user_type"];

    $redirect = ($result["user_type"] === 'Vendor') ? '../home.html' : '../home.html';

    echo replyMsg($redirect, true, 200);

    exit;

?>