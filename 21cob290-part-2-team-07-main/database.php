<?php

$dbServername = "localhost";
$dbUsername = "team007";
$dbPassword = "team007";
$dbname = "testdatabase";

$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbname);


if(!$conn){
  die("Connection to database failed!");
}


?>
