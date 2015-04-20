<html>
 <head>
  <title>Location Management</title>
 </head>
 <body>
 <?php
//This is where our database connection is created, it lives under the variable $conn
include 'header.php';



if (isset($_POST['submit'])) {
	openconnection();
	$querystring="INSERT INTO location
	VALUES ('".$_POST['id']."', '".$_POST['city']."', '".$_POST['state']."');";
	//We don't really need to store the result for inserts/deletes, but it helps with debugging
	$result = dbquery($querystring);
	closeconnection();
	//echo $querystring."\n";
}

if(isset($_POST['remove'])) {
	openconnection();
	$querystring = "DELETE FROM location WHERE location_id='".$_POST['remove_id']."';";
	//We don't really need to store the result for inserts/deletes, but it helps with debugging
	$result = dbquery($querystring);
	closeconnection();
}


?>

 <table style="width:50%">
  <tr>
    <td>
	<form action="" method="post">
		ID:<br>
		<input type="text" name="id">
		<br>
		City:<br>
		<input type="text" name="city">
		<br>
		State:<br>
		<input type="text" name="state">
		<br>
		<input type="submit" value="Add Location" name="submit">
		</form> 
	</td>
	<td>
	<table  border=1>
		<tr>
			<th>ID</th>
			<th>City</th>
			<th>State</th>  
		</tr>
		
			<?php
			openconnection();
			$sql = "SELECT * FROM location;";
			$result = dbquery($sql);
			closeconnection();
			//This little tidbit right here will loop through the query and print a new row in the table with it's info.
			while($resultarray = mysqli_fetch_array($result)){
				echo "<tr>";
					echo "<td>"; print($resultarray['location_id']); echo "</td>";
					echo "<td>"; print($resultarray['city']); echo "</td>";
					echo "<td>"; print($resultarray['state']); echo "</td>";
				echo "</tr>";
			}
			?>
		</tr>
	</table>
	</td>
	<td>
		<form action="" method="post">
			ID to Remove: <input type="text" name="remove_id">
			<input type="submit" value="Remove" name="remove">
		</form>
	</td
  </tr>
</table> 



 </body>
</html>

