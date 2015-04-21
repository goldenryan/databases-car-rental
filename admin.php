<html>
 <head>
  <title>Admin</title>
 </head>
 <body>
 
 <?php
//This is where our database connection is created, it lives under the variable $conn
include 'header.php';

if (isset($_POST['arrive'])) {
	if(is_numeric($_POST['tripid'])){	
		openconnection();
		//set the car to not reserved because trip has ended
		$querystring="UPDATE cars SET reserved = 0 WHERE cars.vin = (SELECT vin FROM with_car WHERE trip_id='".$_POST['tripid']."');";
		$result = dbquery($querystring);
		if($result)
			echo "trip has arrived";
		
		//change location of the car where it arrived

		$querystring="UPDATE is_at SET location_id = (SELECT location_id FROM to_loc WHERE trip_id ='".$_POST['tripid']."') WHERE is_at.vin = (SELECT vin FROM with_car WHERE trip_id='".$_POST['tripid']."');";
		$result = dbquery($querystring);
		if($result)
			echo " and is now at the destined location";
		else
			echo " but is not at the destined location(error)";

		closeconnection();
	}else
		echo "<p style='color:red'>Trip ID must be an integer</p>";
}
?>
	<form action=""  method="post">
	<br><br>
		TripID:<br>
		<input type="text" name="tripid">
		<br><br>
		<input type="submit" value="arrive" name="arrive">
	</form>
	<br><br>
	Cars that are reserved
	<table border=1>
		<tr>
			<th>VIN</th>
			<th>Make</th>
			<th>Model</th>  
			<th>Year</th> 
			<th>Capacity</th> 
			<th>MPG</th> 
			<th>Miles</th>
			<th>Reserved</th>
			<th>Location</th>
		</tr>
		
			<?php
			openconnection();
			$sql = "SELECT * FROM cars WHERE reserved = 1;";
			$result = dbquery($sql);

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
					$query = "select butts.city from 
									(select is_at.vin, location.location_id, location.city, location.state from is_at inner join location on is_at.location_id = location.location_id) butts 
									where butts.vin ='".$resultarray['vin']."';";
					$locationresult = dbquery($query);
					//echo $query;
					$locarray = mysqli_fetch_array($locationresult);
					echo "<td>"; print($locarray['city']); echo "</td>";
				echo "</tr>";
			}
			closeconnection();
			?>
		</tr>
	</table>
 </body>
</html>