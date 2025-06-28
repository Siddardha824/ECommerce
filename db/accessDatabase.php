<?php

include_once "config.php";
function connect_db()
{
    global $database, $database_user, $database_admin, $utype;
    $db_connection = new mysqli(
        $database["host"],
        $utype === "admin" ? $database_admin["username"] : $database_user["username"],
        $utype === "admin" ? $database_admin["password"] : $database_user["password"],
        $database["database_name"],
        $database["port"]
    );

    if ($db_connection->connect_error) {
        return replyMsg("Database connection failed: " . $db_connection->connect_error, false, 500);
    }

    return $db_connection;
}

function replyMsg($message, $success = true, $httpCode = 200)
{
    http_response_code($httpCode);
    header('Content-Type: application/json');
    error_log("[Error] $message");

    return json_encode([
        "success" => $success,
        "message" => $message
    ]);
}

function checkUserName($username)
{
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

function registerUser($username, $hashedPassword, $userType)
{
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

function verifyLoginCredentials($username, $password)
{
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

function getProducts($userID = null)
{
    $db_connection = connect_db();
    if (!$db_connection) {
        return replyMsg("Database connection failed.", false, 500);
    }

    $query = "SELECT * FROM products";

    if ($userID !== null) {
        $query .= " WHERE user_id = ?";
        $stmt = $db_connection->prepare($query);
        if (!$stmt) {
            $db_connection->close();
            return replyMsg("Failed to prepare product query.", false, 500);
        }
        $stmt->bind_param("i", $userID);
        if (!$stmt->execute()) {
            $stmt->close();
            $db_connection->close();
            return replyMsg("Failed to execute product query.", false, 500);
        }
        $result = $stmt->get_result();
        $stmt->close();
    } else {
        $result = $db_connection->query($query);
    }

    if (!$result) {
        $db_connection->close();
        return replyMsg("Failed to retrieve products: " . $db_connection->error, false, 500);
    }

    if ($result->num_rows === 0) {
        $db_connection->close();
        return replyMsg("No products available.", true, 200);
    }

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    $db_connection->close();
    return replyMsg(json_encode($products), true, 200);
}

function getCart($userId)
{
    $db_connection = connect_db();
    if (!$db_connection) {
        return replyMsg("Database connection failed.", false, 500);
    }

    $query = "SELECT * FROM cart JOIN products ON cart.product_id = products.product_id WHERE cart.user_id = ?";
    $stmt = $db_connection->prepare($query);
    if (!$stmt) {
        $db_connection->close();
        return replyMsg("Failed to prepare cart query.", false, 500);
    }

    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        $stmt->close();
        $db_connection->close();
        return replyMsg("Failed to execute cart query.", false, 500);
    }

    $result = $stmt->get_result();
    if (!$result) {
        $stmt->close();
        $db_connection->close();
        return replyMsg("Failed to retrieve cart items.", false, 500);
    }

    if ($result->num_rows === 0) {
        $stmt->close();
        $db_connection->close();
        return replyMsg("No items in the cart.", true, 200);
    }

    $cartItems = [];
    while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
    }

    $stmt->close();
    $db_connection->close();

    return replyMsg(json_encode($cartItems), true, 200);
}

function getOrders($userId)
{
    global $utype;
    $db_connection = connect_db();
    if (!$db_connection) {
        return replyMsg("Database connection failed.", false, 500);
    }

    $query = "SELECT * FROM orders JOIN products ON orders.product_id = products.product_id WHERE";
    $query .= $utype === "Vendor" ? " products.user_id = ?" : " orders.user_id = ?";
    $stmt = $db_connection->prepare($query);
    if (!$stmt) {
        $db_connection->close();
        return replyMsg("Failed to prepare orders query.", false, 500);
    }

    $stmt->bind_param("i", $userId);
    if (!$stmt->execute()) {
        $stmt->close();
        $db_connection->close();
        return replyMsg("Failed to execute orders query.", false, 500);
    }

    $result = $stmt->get_result();
    if (!$result) {
        $stmt->close();
        $db_connection->close();
        return replyMsg("Failed to retrieve orders.", false, 500);
    }

    if ($result->num_rows === 0) {
        $stmt->close();
        $db_connection->close();
        return replyMsg("No orders found.", true, 200);
    }

    $orders = [];
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }

    $stmt->close();
    $db_connection->close();

    return replyMsg(json_encode($orders), true, 200);
}
