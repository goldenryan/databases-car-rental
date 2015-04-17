<html>
 <head>
  <title>PHP Test</title>
 </head>
 <body>
 <?php
include 'create_db.php';
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "rectum";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM renter;";
$result = $conn->query($sql);

print_r($result->fetch_assoc());
$conn->close();
?>
 </body>
</html>