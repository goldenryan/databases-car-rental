<html>
 <head>
  <title>User Management</title>
 </head>
 <body>
 <?php
//This is where our database connection is created, it lives under the variable $conn
include 'header.php';



if (isset($_POST['submit'])) {
	if(is_numeric($_POST['age'])){
		$user = "pooter";
		openconnection();
		$querystring="INSERT INTO renter (name,age)
		VALUES ('".$_POST['name']."', '".$_POST['age']."');";
		//We don't really need to store the result for inserts/deletes, but it helps with debugging
		$result = dbquery($querystring);
		
		closeconnection();
		//echo $querystring."\n";
	}else
		echo "<p style='color:red'>Age has to be an integer</p>";
}

if(isset($_POST['remove'])) {
	if(is_numeric($_POST['remove_id'])){
		openconnection();
		$querystring = "DELETE FROM renter WHERE renter_id='".$_POST['remove_id']."';";
		//We don't really need to store the result for inserts/deletes, but it helps with debugging
		$result = dbquery($querystring);
		
		closeconnection();
	}else
		echo "<p style='color:red'>Remove ID has to be an integer</p>";
}


?>

 <table style="width:100%">
  <tr>
    <td>
	<form action="" method="post">
		Name:<br>
		<input type="text" name="name">
		<br>
		Age:<br>
		<input type="text" name="age">
		<br>
		<input type="submit" value="Add Renter" name="submit">
		</form> 
	</td>
	<td>
	<table  border=1>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Age</th>  
		</tr>
		
			<?php
			openconnection();
			$sql = "SELECT * FROM renter;";
			$result = dbquery($sql);
			closeconnection();
			//This little tidbit right here will loop through the query and print a new row in the table with it's info.
			while($resultarray = mysqli_fetch_array($result)){
				echo "<tr>";
					echo "<td>"; print($resultarray['renter_id']); echo "</td>";
					echo "<td>"; print($resultarray['name']); echo "</td>";
					echo "<td>"; print($resultarray['age']); echo "</td>";
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

