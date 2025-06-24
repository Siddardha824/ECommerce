<?php

    header('Content-Type: application/json');
    require_once "../DatabaseScripts/accessDatabase.php";

    // 1. Get POST data
    $username = $_POST['uname'] ?? '';
    $password = $_POST['upass1'] ?? '';
    $confirm  = $_POST['upass2'] ?? '';
    $userType = $_POST['utype'] ?? 'customer';

    // 2. Basic validation
    if (!$username || !$password || !$confirm) {
        echo replyMsg("Missing required fields.", false, 400);
        exit;
    }

    if ($password !== $confirm) {
        echo replyMsg("Passwords do not match.", false, 200);
        exit;
    }

    if (strlen($username) < 3 || strlen($password) < 6) {
        echo replyMsg("Username or password too short.", false, 200);
        exit;
    }

    // 3. Check if username exists
    $checkArr = json_decode(checkUserName($username), true);
    if ($checkArr['success'] && $checkArr['message']) {
        echo replyMsg("Username already exists.", false, 200);
        exit;
    }

    // 4. Hash the password server-side
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // 5. Register user
    echo registerUser($username, $hashedPassword, $userType);

?>