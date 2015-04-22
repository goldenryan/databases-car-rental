 <?php

 
$servername = "localhost";
$username = "root";
$password = "";
$db = "rectum";
$conn = new mysqli($servername, $username, $password);

 function openconnection(){
	global $servername, $username, $password, $conn;
	 // Create connection
	$conn = new mysqli($servername, $username, $password);
	$conn->query("use rectum;");
 }
 function dbquery($querystring){
	 global $conn;
	 return $conn->query($querystring);
 }
 function closeconnection(){
	global $servername, $username, $password, $conn;
	mysqli_close($conn); 
 }

openconnection();

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
/* Check to see if our database exists */
if ($conn->query("USE $db") === FALSE) {
    printf("Database doesn't exist. We will create it along with it's tables.\n");
	if($conn->query("CREATE DATABASE $db") === TRUE){
		printf("Database created successfully, using and running the table check.\n");
		$conn->query("USE $db");
	}
	else{
		printf("Database creation failed.\n");
	}
}
if ($conn->query("create table if not exists trip (trip_id int, date varchar(30), departure_time varchar(30));") === FALSE) {
	printf("Failed to create table trip.");
}
if ($conn->query("create table if not exists renter (renter_id int, name varchar(50), age int);") === FALSE) {
	printf("Failed to create table renter");
}
if ($conn->query("create table if not exists cars(vin varchar(50), make varchar(20), model varchar(20), year int, capacity int, mpg int, miles int, reserved bool);") === FALSE) {
	printf("Failed to create table cars");
}
if ($conn->query("create table if not exists location (location_id int, city varchar(30), state varchar(30));") === FALSE) {
	printf("Failed to create table location");
}
if ($conn->query("create table if not exists takes(renter_id int, trip_id int);") === FALSE) {
	printf("Failed to create table takes");
}
if ($conn->query("create table if not exists to_loc (location_id int, trip_id int);") === FALSE)  {
	printf("Failed to create table to_loc");
}
if ($conn->query("create table if not exists with_car (vin varchar(50),trip_id int);") === FALSE)  {
	printf("Failed to create table with_car");
}
if ($conn->query("create table if not exists is_at (vin varchar(50),location_id int);") === FALSE)  {
	printf("Failed to create table is_at");
}
//alters after here
if ($conn->query("ALTER TABLE location ADD PRIMARY KEY (location_id);") === FALSE)  {
	printf("Failed to create primary key in location");
}
if ($conn->query("ALTER TABLE location MODIFY COLUMN location_id INT NOT NULL AUTO_INCREMENT;") === FALSE)  {
	printf("Failed to auto increment primary key in location");
}
if ($conn->query("ALTER TABLE cars ADD PRIMARY KEY (vin);") === FALSE)  {
	printf("Failed to create primary key in cars");
}
if ($conn->query("ALTER TABLE renter ADD PRIMARY KEY (renter_id);") === FALSE)  {
	printf("Failed to create primary key in renter");
}
if ($conn->query("ALTER TABLE renter MODIFY COLUMN renter_id INT NOT NULL AUTO_INCREMENT;") === FALSE)  {
	printf("Failed to auto increment primary key in renter");
}
if ($conn->query("ALTER TABLE trip ADD PRIMARY KEY (trip_id);") === FALSE)  {
	printf("Failed to create primary key in trip");
}
if ($conn->query("ALTER TABLE trip MODIFY COLUMN trip_id INT NOT NULL AUTO_INCREMENT;") === FALSE)  {
	printf("Failed to auto increment primary key in trip");
}
//foreign keys after here
if ($conn->query("ALTER TABLE is_at ADD CONSTRAINT loc_id FOREIGN KEY (location_id) REFERENCES location(location_id) ON DELETE CASCADE;") === FALSE)  {
	printf("Failed to add location foreign key in is_at");
}
if ($conn->query("ALTER TABLE is_at  ADD CONSTRAINT fk_vin FOREIGN KEY (vin) REFERENCES cars(vin) ON DELETE CASCADE;") === FALSE)  {
	printf("Failed to add car foreign key in is_at");
}
if ($conn->query("ALTER TABLE with_car ADD CONSTRAINT fk_vin_wc FOREIGN KEY (vin) REFERENCES cars(vin) ON DELETE CASCADE;") === FALSE)  {
	printf("Failed to add car foreign key in with_car");
}
if ($conn->query("ALTER TABLE with_car ADD CONSTRAINT fk_tid_wc FOREIGN KEY (trip_id) REFERENCES trip(trip_id) ON DELETE CASCADE;") === FALSE)  {
	printf("Failed to add trip foreign key in with_car");
}
if ($conn->query("ALTER TABLE to_loc ADD CONSTRAINT fk_lid_tl FOREIGN KEY (location_id) REFERENCES location(location_id) ON DELETE CASCADE;") === FALSE)  {
	printf("Failed to add location foreign key in to_loc");
}
if ($conn->query("ALTER TABLE to_loc ADD CONSTRAINT fk_tid_tl FOREIGN KEY (trip_id) REFERENCES trip(trip_id) ON DELETE CASCADE;") === FALSE)  {
	printf("Failed to add trip foreign key in to_loc");
}
if ($conn->query("ALTER TABLE takes ADD CONSTRAINT fk_rid_t FOREIGN KEY (renter_id) REFERENCES renter(renter_id) ON DELETE CASCADE;") === FALSE)  {
	printf("Failed to add renter foreign key in takes");
}
if ($conn->query("ALTER TABLE takes ADD CONSTRAINT fk_tid_t FOREIGN KEY (trip_id) REFERENCES trip(trip_id) ON DELETE CASCADE;") === FALSE)  {
	printf("Failed to add trip foreign key in takes");
}

//This makes it so the is_at table cannot hold duplicate entries of vin. Saying a car is a a location multiple times is a waste.
//$conn->query("ALTER TABLE is_at ADD UNIQUE (vin);");


closeconnection();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
  <title>My first styled page</title>
</head>
<style>
ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
}

li {
    float: left;
}

a {
    display: block;
    width: 80px;
    background-color: #dddddd;
}
</style>

<body>
<!-- Site navigation menu -->
<ul class="navbar">
  <li><a href="register.php">Register</a>
  <li><a href="cars.php">Cars</a>
  <li><a href="locations.php">Locations</a>
  <li><a href="trips.php">Trips</a>
  <li><a href="admin.php">Admin</a>
  <!--<li><a href="links.html">Links</a>-->
</ul>


</body>
</html>
