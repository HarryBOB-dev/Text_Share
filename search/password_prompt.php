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

// Get the ID from the query string
$id = $conn->real_escape_string($_GET['id']);

// Query to get the text and password
$sql = "SELECT * FROM shared_texts WHERE id='$id'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Required</title>
    <style>
      body{
        background-color: #333333;
      }
      #enter_psw{
        color: white;
        top: 35%;
        left: 50%;
        position: absolute;
        transform: translate(-50%, -50%);
        font-size: 400%;
      }
      #title{
        color: white;
        top: 20%;
        left: 50%;
        position: absolute;
        transform: translate(-50%, -50%);
        font-size: 400%;
      }
      #psw_field{
        background: #dddddd;
        color: #666666;
        padding:1em;
        border-radius:10px;
        border:2px solid transparent;
        outline: none;
        height:4%;
        width: 50%;
        text-align: left;
        left: 50%;
        top:50%;
        transform: translate(-50%, -50%);
        position: absolute;
        font-size:200% ;
      }
      #access_btn{
        padding: 1px 6px;
        border: none;
        border-radius: 16px;
        color: white;
        background-color: grey;
        left:50%;
        top:65%;
        position: absolute;
        text-decoration: none;
        transition-duration: 0.4s;
        z-index: -1;
        font-size: 800%;  
        transform: translate(-50%, -50%); 
      }
      #access_btn:hover{
        background-color: #04AA6D;
        border-radius: 32px;
      }
    </style>
</head>
<body>
    <h1 id = "title">Access Protected Text</h1>
    <form action="check_password.php" method="POST">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
        <label id = "enter_psw" for="password">Enter Password:</label>
        <input type="password" name="password" id="psw_field" required>
        <button type="submit" id = "access_btn">Access Text</button>
    </form>
</body>
</html>