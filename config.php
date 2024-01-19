<?php
$dbname = "projectStore";
$username = "root";
$password = "";
$host = "localhost";

$connection = mysqli_connect($host, $username, $password, $dbname);

if (!$connection) {
    die("Database Connection Error - " . mysqli_connect_error());
}
