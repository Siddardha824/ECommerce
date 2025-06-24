<?php

    include_once "config.php";
    function connect_db() {
        global $database, $database_user, $database_admin;
        $db_connection = new mysqli(
            $database["host"],
            $database_user["username"],
            $database_user["password"],
            $database["database_name"],
            $database["port"]
        );
        
        if ($db_connection->connect_error) {
            return replyMsg("Database connection failed: " . $db_connection->connect_error, false, 500);
        }

        return $db_connection;
    }

    function replyMsg($message, $success = true, $httpCode = 200) {
        http_response_code($httpCode);
        header('Content-Type: application/json');
        error_log("[Error] $message");

        return json_encode([
            "success" => $success,
            "message" => $message
        ]);
    }

    function checkUserName($username) {
        $db_connection = connect_db();
        if (!$db_connection) {
            return replyMsg("Database connection failed.", false, 500);
        }

        $query = "SELECT user_id FROM users WHERE user_name = ?";
        $stmt = $db_connection->prepare($query);
        if (!$stmt) {
            $db_connection->close();
            return replyMsg("Failed to prepare statement for username check.", false, 500);
        }

        $stmt->bind_param("s", $username);
        if (!$stmt->execute()) {
            $stmt->close();
            $db_connection->close();
            return replyMsg("Failed to execute username check query.", false, 500);
        }

        $result = $stmt->get_result();
        if (!$result) {
            $stmt->close();
            $db_connection->close();
            return replyMsg("Failed to retrieve result for username check.", false, 500);
        }

        $exists = $result->num_rows > 0;

        $stmt->close();
        $db_connection->close();

        return replyMsg($exists, true, 200);
    }

    function registerUser($username, $hashedPassword, $userType) {
        $db_connection = connect_db();
        if (!$db_connection) {
            return replyMsg("Database connection failed.", false, 500);
        }

        $query = "INSERT INTO users (user_name, password, user_type) VALUES (?, ?, ?)";
        $stmt = $db_connection->prepare($query);
        if (!$stmt) {
            $db_connection->close();
            return replyMsg("Failed to prepare registration statement.", false, 500);
        }

        $stmt->bind_param("sss", $username, $hashedPassword, $userType);
        if (!$stmt->execute()) {
            $stmt->close();
            $db_connection->close();
            return replyMsg("User registration failed. Username might already exist.", false, 200);
        }

        $stmt->close();
        $db_connection->close();

        return replyMsg("User registered successfully.", true, 200);
    }

    function verifyLoginCredentials($username, $password) {
        $db_connection = connect_db();
        if (!$db_connection) {
            return replyMsg("Database connection failed.", false, 500);
        }

        $stmt = $db_connection->prepare("SELECT user_id, user_name, password, user_type FROM users WHERE user_name = ?");
        if (!$stmt) {
            $db_connection->close();
            return replyMsg("Query preparation failed.", false, 500);
        }

        $stmt->bind_param("s", $username);
        if (!$stmt->execute()) {
            $stmt->close();
            $db_connection->close();
            return replyMsg("Failed to execute login query.", false, 500);
        }
        $result = $stmt->get_result();

        if (!$result) {
            $stmt->close();
            $db_connection->close();
            return replyMsg("Failed to retrieve login result.", false, 500);
        }

        if ($result->num_rows === 0) {
            $stmt->close();
            $db_connection->close();
            return replyMsg("Incorrect credentials.", false, 200);
        }

        $user = $result->fetch_assoc();

        if (!password_verify($password, $user["password"])) {
            $stmt->close();
            $db_connection->close();
            return replyMsg("Incorrect credentials.", false, 200);
        }

        $stmt->close();
        $db_connection->close();

        return replyMsg(json_encode([
            "user_id" => $user["user_id"],
            "user_name" => $user["user_name"],
            "user_type" => $user["user_type"]
        ]), true, 200);
    }


?>
