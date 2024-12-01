<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$servername = "SECRET"; // Your host
$username = "SECRET"; // Your MySQL username
$password = "SECRET"; // Your MySQL password
$dbname = "SECRET"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the input from the textarea
    $shared_text = $conn->real_escape_string(trim($_POST['shared_text']));

    // Query the database
    $sql = "SELECT * FROM shared_texts WHERE name LIKE '%$shared_text%'";
    $result = $conn->query($sql);

    // Check if results exist
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Redirect based on password requirement
            if (!empty($row["password"])) {
                header("Location: password_prompt.php?id=" . $row["id"]);
                exit();
            } else {
                header("Location: result_display.php?id=" . $row["id"]);
                exit();
            }
        }
    } else {
        echo "<script>alert('No results found for \"$shared_text\"'); window.location.href='index.html';</script>";
    }
}

// Close the connection
$conn->close();
?>