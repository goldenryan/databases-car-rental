<html>
 <head>
  <title>Trip Management</title>
 </head>
 <body>
 
 <?php
//This is where our database connection is created, it lives under the variable $conn
include 'header.php';



if (isset($_POST['submit'])) {
	openconnection();
	$querystring="INSERT INTO trip
	VALUES ('".$_POST['id']."', '".$_POST['date']."', '".$_POST['deptime']."');";
	//We don't really need to store the result for inserts/deletes, but it helps with debugging
	$result = dbquery($querystring);
	
	
	//Update our relation tables
	$querystring="INSERT INTO with_car VALUES ('".$_POST['car']."','".$_POST['id']."');";
	$result = dbquery($querystring);
	
	$querystring="INSERT INTO to_loc VALUES ('".$_POST['destination']."','".$_POST['id']."');";
	$result = dbquery($querystring);
	
	$querystring="INSERT INTO takes VALUES ('".$_POST['renter']."','".$_POST['id']."');";
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
	$querystring = "DELETE FROM trip WHERE trip_id='".$_POST['remove_id']."';";
	//We don't really need to store the result for inserts/deletes, but it helps with debugging
	$result = dbquery($querystring);
	
	
	//Update our relation tables
	$querystring = "DELETE FROM with_car WHERE trip_id='".$_POST['remove_id']."';";
	$result = dbquery($querystring);
	
	$querystring = "DELETE FROM to_loc WHERE trip_id='".$_POST['remove_id']."';";
	$result = dbquery($querystring);
	
	$querystring = "DELETE FROM takes WHERE trip_id='".$_POST['remove_id']."';";
	$result = dbquery($querystring);
	
	closeconnection();
}


?>

 <table style="width:100%">
  <tr>
    <td>
	<form action="" method="post">
	<br><br>
		Starting Location (please select before entering the rest):<br>
			<select name="location_choice">
				<?php
					openconnection();
					$sql = "SELECT * FROM location;";
					$result = dbquery($sql);
					closeconnection();
					//This little tidbit right here will loop through the query and print a new row in the table with it's info.
					while($resultarray = mysqli_fetch_array($result)){
						$selected = '';
						if(isset($_POST['locationset'])) {
							if($resultarray['location_id'] == $_POST['location_choice']) { $selected = " selected"; }
						}
						echo '<option value="'.$resultarray['location_id'].'"'.$selected.'>'.$resultarray['city'].'</option>';
					}
					?>
			</select>
			<input type="submit" value="Ok" name="locationset">
		</form>
	<form action="" method="post">
		
	
		ID:<br>
		<input type="text" name="id" >
		<br>
		Date:<br>
		<input type="text" name="date">
		<br>
		Departure Time:<br>
		<input type="text" name="deptime">
		<br>
		Car(VIN, Model):<br>
		<select name="car">
			<?php
				if(isset($_POST['locationset'])) {
					openconnection();
					$sql = "select butts.vin, butts.city from 
									(select is_at.vin, location.location_id, location.city, location.state from is_at inner join location on is_at.location_id = location.location_id) butts 
									where butts.location_id ='".$_POST['location_choice']."';";
					$result = dbquery($sql);
					//$resultarray = mysqli_fetch_array($result);
					//echo $sql;
					//$tmpquery = "select cars.model, cars.vin from cars where cars.vin = '".$resultarray['vin']."';";
					//$carresult = dbquery($tmpquery);
					
					//This little tidbit right here will loop through the query and print a new row in the table with it's info.
					while($resultarray = mysqli_fetch_array($result)){
						$tmpquery = "select cars.model, cars.vin, cars.reserved from cars where cars.vin = '".$resultarray['vin']."';";
						$carresult = dbquery($tmpquery);
						$cararray = mysqli_fetch_array($carresult);
						if($cararray['reserved'] == 0)
							echo '<option value="'.$cararray['vin'].'">'.$cararray['vin'].','.$cararray['model'].'</option>';
					}
					closeconnection();
				}
				?>
		</select>
		<br>
		Destination:<br>
		<select name="destination">
			<?php
				openconnection();
				$sql = "SELECT * FROM location;";
				$result = dbquery($sql);
				closeconnection();
				//This little tidbit right here will loop through the query and print a new row in the table with it's info.
				while($resultarray = mysqli_fetch_array($result)){
					echo '<option value="'.$resultarray['location_id'].'">'.$resultarray['city'].'</option>';
				}
			?>
		</select>
		<br>
		Name:<br>
		<select name="renter">
			<?php
				openconnection();
				$sql = "SELECT * FROM renter;";
				$result = dbquery($sql);
				closeconnection();
				//This little tidbit right here will loop through the query and print a new row in the table with it's info.
				while($resultarray = mysqli_fetch_array($result)){
					echo '<option value="'.$resultarray['renter_id'].'">'.$resultarray['name'].'</option>';
				}
			?>
		</select>
		<br><br>
		<input type="submit" value="Add Trip" name="submit" onclick="submitForms()">
		</form>
		
	</td>
	<td>
	<table border=1>
		<tr>
			<th>ID</th>
			<th>Date</th>
			<th>Departure Time</th>
			<th>Destination</th>
			<th>Car ID</th>
			<th>Renter ID</th>
		</tr>
		
			<?php
			openconnection();
			$sql = "SELECT * FROM trip;";
			$result = dbquery($sql);

			//This little tidbit right here will loop through the query and print a new row in the table with it's info.
			while($resultarray = mysqli_fetch_array($result)){
				echo "<tr>";
					echo "<td>"; print($resultarray['trip_id']); echo "</td>";
					echo "<td>"; print($resultarray['date']); echo "</td>";
					echo "<td>"; print($resultarray['departure_time']); echo "</td>";

					$query = "select butts.city from 
									(select to_loc.trip_id, location.location_id, location.city, location.state from to_loc inner join location on to_loc.location_id = location.location_id) butts 
									where butts.trip_id ='".$resultarray['trip_id']."';";
					$locationresult = dbquery($query);
					//echo $query;
					$locarray = mysqli_fetch_array($locationresult);
					echo "<td>"; print($locarray['city']); echo "</td>";
					$query = "select butts.vin from 
									(select with_car.trip_id, cars.vin from with_car inner join cars on with_car.vin = cars.vin) butts 
									where butts.trip_id ='".$resultarray['trip_id']."';";
					$locationresult = dbquery($query);
					//echo $query;
					$locarray = mysqli_fetch_array($locationresult);
					echo "<td>"; print($locarray['vin']); echo "</td>";
					$query = "select butts.renter_id from 
									(select takes.trip_id, renter.renter_id from takes inner join renter on takes.renter_id = renter.renter_id) butts 
									where butts.trip_id ='".$resultarray['trip_id']."';";
					$locationresult = dbquery($query);
					//echo $query;
					$locarray = mysqli_fetch_array($locationresult);
					echo "<td>"; print($locarray['renter_id']); echo "</td>";	
				echo "</tr>";
			}
			closeconnection();
			?>
		</tr>
	</table>
	</td>
	<td>
		<form action="" method="post">
			ID to Remove: <input type="text" name="remove_id">
			<input type="submit" value="Remove" name="remove">
		</form>
	</td>
  </tr>
</table> 



 </body>
</html>

