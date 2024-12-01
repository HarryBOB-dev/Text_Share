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
    $id = $conn->real_escape_string(trim($_POST['id']));
    $input_password = $conn->real_escape_string(trim($_POST['password']));

    // Query to check the password
    $sql = "SELECT shared_text FROM shared_texts WHERE id='$id' AND password='$input_password'";
    $result = $conn->query($sql);

    // Check if the password is correct
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        
        $show = nl2br(htmlspecialchars($row["shared_text"]));
        
    } else {
        echo "<script>alert('Invalid password. Please try again.'); window.location.href='password_prompt.php?id=" . htmlspecialchars($id) . "';</script>";
    }
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <style>
    body{
      background-color: #333333;
    }
    #Title{
      color: white;
      position: absolute;
      top: 20%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 500%;
    }
    #shared_text{
      background: #dddddd;
      color: #666666;
      padding:1em;
      border-radius:10px;
      border:2px solid transparent;
      outline: none;
      height:80%;
      width: 90%;
      text-align: left;
      left: 50%;
      top:75%;
      transform: translate(-50%, -50%);
      position: absolute;
      font-size:200% ;
    }
  </style>
</head>
<body>
  <h1 id = "Title">Text Shared</h1>
  <a id = "shared_text"> <?php echo $show; ?> </a>
</body>
</html>