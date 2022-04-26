
<?php
$servername ="localhost";
$dbname = "testdatabase";
$username = "team007";
$password = "team007";

$conn = mysqli_connect($servername,$username,$password,$dbname);
if(!$conn){
  die("Connection failed: ". mysqli_connect_error());
}
//  echo "Connected Successfully","<br>";
?>
