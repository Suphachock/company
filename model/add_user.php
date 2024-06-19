<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$fullname = $_POST['fullname'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$department = $_POST['department'] ?? '';
$permission = $_POST['permission'] ?? '';
$arr_permission = implode(',', $permission);

// Prepare and execute the SQL query for checking duplicates
$check_sql = "SELECT COUNT(*) FROM user WHERE username = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param('s', $username);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    echo "มียูเซอร์นี้อยู่แล้วในระบบ!";
} else {
    // Prepare and execute the SQL query for inserting a new record into the 'event_category' table
    $sql = "INSERT INTO user (fullname,username,password,department,permission) VALUES (?,?,?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $fullname, $username, $password, $department, $arr_permission);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "ข้อมูลซ้ำในระบบ!";
    }

    // Close the prepared statement
    $stmt->close();
    // Close the database connection
    $conn->close();
}
