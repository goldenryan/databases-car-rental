<html>
 <head>
  <title>Car Management</title>
 </head>
 <body>
 <?php
//This is where our database connection is created, it lives under the variable $conn
include 'header.php';

openconnection();

if (isset($_POST['submit'])) {
	$querystring="INSERT INTO cars VALUES (".$_POST['vin'].", ".$_POST['make'].", ".$_POST['model'].", ".$_POST['year'].", "
	.$_POST['capacity'].", ".$_POST['mpg'].", ".$_POST['miles'].", ".$_POST['reserved'].");";
	$result = dbquery($querystring);
	
    /*$example = $_POST['vin'];
    $example2 = $_POST['make'];
    echo $example . " " . $example2;*/
	echo "Entry Added.\n";
	echo $querystring."\n";
	echo $result;
}


$sql = "SELECT * FROM cars;";
$result = dbquery($sql);
print_r($result->fetch_assoc());

closeconnection();

//print_r($result->fetch_assoc());

//$conn->close();
?>

<form action="" method="post">
VIN:<br>
<input type="text" name="vin">
<br>
Make:<br>
<input type="text" name="make">
<br>
Model:<br>
<input type="text" name="model">
<br>
Year:<br>
<input type="text" name="year">
<br>
Capacity (persons):<br>
<input type="text" name="capacity">
<br>
MPG:<br>
<input type="text" name="mpg">
<br>
Miles:<br>
<input type="text" name="miles">
<br>
Reserved:<br>
<input type="text" name="reserved">
<br>
<input type="submit" value="Add Car" name="submit">
</form> 


 </body>
</html>

