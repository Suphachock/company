<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$event_category = $_POST['event_category'] ?? '';

// Prepare and execute the SQL query for checking duplicates
$check_sql = "SELECT COUNT(*) FROM event_category WHERE event_category = ?";
$check_stmt = $conn->prepare($check_sql);

if ($check_stmt === false) {
    echo "Failed to prepare the SQL statement for checking duplicates.";
    exit;
}

$check_stmt->bind_param('s', $event_category);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    echo "ข้อมูลซ้ำในระบบ!";
} else {
    // Prepare and execute the SQL query for inserting a new record into the 'event_category' table
    $sql = "INSERT INTO event_category (event_category) VALUES (?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "ข้อมูลซ้ำในระบบ!";
        exit;
    }

    $stmt->bind_param('s', $event_category);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "ข้อมูลซ้ำในระบบ!";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
