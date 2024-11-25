<?php
$host = 'localhost';      // Database host (usually 'localhost')
$db_username = 'root';    // Database username
$db_password = '';        // Database password
$database = 'db_qlbh';      // Database name

// Create a connection to the MySQL database
$mysqli = new mysqli($host, $db_username, $db_password, $database);

if ($mysqli->connect_error) {
  die('Connection Error: ' . $mysqli->connect_error);
}
?>