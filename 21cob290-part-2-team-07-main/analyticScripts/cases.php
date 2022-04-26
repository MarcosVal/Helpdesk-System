<?php
$servername = "localhost";
$dbname ="testdatabase";
$username ="root";
$password  ="";

$conn = mysqli_connect($servername,$username,$password,$dbname);
if(!$conn){
  die("Connection failed: ". mysqli_connect_error());
}
echo "Connected Successfully","<br>";

$sqlQuery = "SELECT CASES.CaseID, CASES.ProblemType,calls.CallID,calls.CallReason,callscases.CaseID FROM  callscases INNER JOIN CASES ON callscases.CaseID =cases.CaseID INNER JOIN calls ON callscases.CallID = calls.CallID";
$result = mysqli_query($conn,$sqlQuery);

$resultsArray =array();

if (mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $resultsArray[]=$row;
      }
}

echo json_encode($resultsArray);