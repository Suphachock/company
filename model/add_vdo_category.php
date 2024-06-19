<?php
// Include the database connection file
include('../conn.php');

// Fetch the data from the POST request
$vdo_category = $_POST['vdo_category'] ?? '';

// Prepare and execute the SQL query for checking duplicates
$check_sql = "SELECT COUNT(*) FROM vdo_category WHERE vdo_category = ?";
$check_stmt = $conn->prepare($check_sql);

if ($check_stmt === false) {
    echo "Failed to prepare the SQL statement for checking duplicates.";
    exit;
}

$check_stmt->bind_param('s', $vdo_category);
$check_stmt->execute();
$check_stmt->bind_result($count);
$check_stmt->fetch();
$check_stmt->close();

if ($count > 0) {
    echo "Duplicate Vdo Category!";
} else {
    // Prepare and execute the SQL query for inserting a new record into the 'vdo_category' table
    $sql = "INSERT INTO vdo_category (vdo_category) VALUES (?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        echo "Failed to prepare the SQL statement.";
        exit;
    }

    $stmt->bind_param('s', $vdo_category);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "Failed to add Vdo Category!";
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
