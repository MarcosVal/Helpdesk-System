<?php
include "connect.php";

// $startDate1 = $_GET["startDate"];
// $endDate1 = "2022-05-05";
$sqlQuery = "SELECT employees.EmpID,employees.Name FROM employees WHERE employees.Job ='Specialist'";
$result = mysqli_query($conn,$sqlQuery);

$resultsArray =array();

if (mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $resultsArray[]=$row;
      }
}

echo json_encode($resultsArray);
// echo $startDate1;

?>