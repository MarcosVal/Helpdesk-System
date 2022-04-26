<?php
require_once 'database.php';
session_start();
$log_id = $_SESSION["empID"];
$job = $_SESSION["Job"];

$job_query = "SELECT Job from employees where EmpID = $log_id";
$job = mysqli_fetch_row(mysqli_query($conn, $job_query))[0];

$name_query = "SELECT name from employees where empid = $log_id";
$name = mysqli_fetch_row(mysqli_query($conn, $name_query))[0];

function toa($result){
  $emptyArray = array();
  if(mysqli_num_rows($result) > 0){
    while($row = mysqli_fetch_array($result)){
      array_push($emptyArray,$row);
    }
  }
  return $emptyArray;
}

if($job == "Specialist"){
  $wholeSpecialistData = "SELECT * FROM cases WHERE EmpID='$log_id' ORDER BY CaseStatus DESC";
  $whole_query = mysqli_query($conn, $wholeSpecialistData);
  $rows = mysqli_num_rows($whole_query);
  $finalResult = toa($whole_query);

  $newResult = json_encode($finalResult);
  echo $newResult;
}
else if($job == "Helpdesk Operator"){
  $wholeData = "SELECT * FROM cases ORDER BY CaseStatus DESC";
  $wholeDataQuery = mysqli_query($conn, $wholeData);
  $rows = mysqli_num_rows($wholeDataQuery);

  $finalResult = toa($wholeDataQuery);
  $newResult = json_encode($finalResult);
  echo $newResult;
}
// $wholeData = "SELECT * FROM cases";
// $wholeDataQuery = mysqli_query($conn, $wholeData);
// $rows = mysqli_num_rows($wholeDataQuery);
// echo "<script>console.log($rows[0])</script>";
// function to populate result into an array
//
// $finalResult = toa($wholeDataQuery);
// $newResult = json_encode($finalResult);


?>
