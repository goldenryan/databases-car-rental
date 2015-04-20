<html>
 <head>
  <title>Car Management</title>
 </head>
 <body>
 <?php
//This is where our database connection is created, it lives under the variable $conn
include 'header.php';



if (isset($_POST['submit'])) {
	openconnection();
	$querystring="INSERT INTO cars
	VALUES ('".$_POST['vin']."', '".$_POST['make']."', '".$_POST['model']."', '".$_POST['year']."', '"
	.$_POST['capacity']."', '".$_POST['mpg']."', '".$_POST['miles']."', '".$_POST['reserved']."');";
	//We don't really need to store the result for inserts/deletes, but it helps with debugging
	$result = dbquery($querystring);
	closeconnection();
    /*$example = $_POST['vin'];
    $example2 = $_POST['make'];
    echo $example . " " . $example2;
	echo "Entry Added.\n";
	echo $querystring."\n";
	echo $result;*/
}

if(isset($_POST['remove'])) {
	openconnection();
	$querystring = "DELETE FROM cars WHERE vin='".$_POST['remove_vin']."';";
	//We don't really need to store the result for inserts/deletes, but it helps with debugging
	$result = dbquery($querystring);
	closeconnection();
}


?>

 <table style="width:50%">
  <tr>
    <td>
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
	</td>
	<td>
	<table  border=1>
		<tr>
			<th>VIN</th>
			<th>Make</th>
			<th>Model</th>  
			<th>Year</th> 
			<th>Capacity</th> 
			<th>MPG</th> 
			<th>Miles</th>
			<th>Reserved</th>
		</tr>
		
			<?php
			openconnection();
			$sql = "SELECT * FROM cars;";
			$result = dbquery($sql);
			closeconnection();
			//This little tidbit right here will loop through the query and print a new row in the table with it's info.
			while($resultarray = mysqli_fetch_array($result)){
				echo "<tr>";
					echo "<td>"; print($resultarray['vin']); echo "</td>";
					echo "<td>"; print($resultarray['make']); echo "</td>";
					echo "<td>"; print($resultarray['model']); echo "</td>";
					echo "<td>"; print($resultarray['year']); echo "</td>";
					echo "<td>"; print($resultarray['capacity']); echo "</td>";
					echo "<td>"; print($resultarray['mpg']); echo "</td>";
					echo "<td>"; print($resultarray['miles']); echo "</td>";
					echo "<td>"; print($resultarray['reserved']); echo "</td>";
				echo "</tr>";
			}
			?>
		</tr>
	</table>
	</td>
	<td>
		<form action="" method="post">
			VIN to Remove: <input type="text" name="remove_vin">
			<input type="submit" value="Remove" name="remove">
		</form>
	</td
  </tr>
</table> 



 </body>
</html>

