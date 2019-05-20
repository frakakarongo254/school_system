<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$db = "school_system254";

		// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword,$db);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
$path='http://localhost/ChildCareIMS/';
?>