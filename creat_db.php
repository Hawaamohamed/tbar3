<?php
$con = mysqli_connect("localhost","root","");
if(!$con){ 
die("Connection error: " . mysqli_connect_error());
}
if(mysqli_query($con, "CREATE DATABASE my_db"))
 {
	echo "Database created";
 }
else
 {
	 echo "Error creating database: " . mysqli_error($con);
 }
mysqli_close($con);
?>
