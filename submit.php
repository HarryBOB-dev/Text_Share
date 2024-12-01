<?php
// Start the session
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database configuration
$servername = "SECRET"; // Your host
$username = "SECRET"; // Your MySQL username
$password = "SECRET"; // Your MySQL password
$dbname = "SECRET"; // Your database name 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sanitize input
$shared_text = $conn->real_escape_string(trim($_POST['shared_text']));
$name = $conn->real_escape_string(trim($_POST['name']));
$password = $conn->real_escape_string(trim($_POST['password'])); 

// Check if the text already exists
$check_sql = "SELECT * FROM shared_texts WHERE name = '$name'";
$check_result = $conn->query($check_sql);

$message = "";

if ($check_result->num_rows > 0) {
    $message = "Error: A text with the name '$name' already exists.";
} else {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO shared_texts (shared_text, name, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $shared_text, $name, $password);

    // Execute the statement
    if ($stmt->execute()) {
        $message = "Text shared successfully! The text '$shared_text' has been added.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();

// Output JavaScript to show alert and redirect
echo "<script type='text/javascript'>
    alert(`${message}`);
    window.location.href = 'index.html'; // Change to your actual HTML file
</script>";
?>