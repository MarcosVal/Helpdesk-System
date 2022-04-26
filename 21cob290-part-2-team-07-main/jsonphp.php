<?php

$username = 'team007';
$password = 'team007';
$servername = 'localhost';
$dbName = 'testDatabase';

$conn = mysqli_connect($servername, $username, $password, $dbName);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$jsonTest = "testjson.json";
$arr_data = array();

$jsonData = file_get_contents($jsonTest);
$arr_data = json_decode($jsonData, true);


$Case_No = "16";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $callsArray = array(
        'Case_No' => $Case_No,
        'Case_Type' => $_POST['Case_Type'],
        'Caller' => $_POST['Caller'],
        'Hardware_Serial_Number' => $_POST['Hardware_Serial_Number'],
        'Software' => $_POST['Software'],
        'Operating_System' => $_POST['Operating_System'],
        'Operator' => $_POST['Operator'],
        'Date_of_Call' => $_POST['Date_of_Call'],
        'Caller_ID' => $_POST['Caller_ID'],
        'Job_Title' => $_POST['Job_Title'],
        'Department' => $_POST['Department'],
        'Telephone_Number' => $_POST['Telephone_Number'],
        'Case_Status' => $_POST['Case_Status'],
        'CallReason' => $_POST['Call_Notes'],
        'CallStartTime' => $_POST['CallStartTime']
    );
}

$Case_Type= $_REQUEST['Case_Type'];
$Caller = $_REQUEST['Caller'];
$Hardware_Serial_Number = $_REQUEST['Hardware_Serial_Number'];
$Software = $_REQUEST['Software'];
$Operating_System = $_REQUEST['Operating_System'];
$Operator = $_REQUEST['Operator'];
$Date_of_Call = $_REQUEST['Date_of_Call'];
$Caller_ID = $_REQUEST['Caller_ID'];
$Job_Title = $_REQUEST['Job_Title'];
$Department = $_REQUEST['Department'];
$Telephone_Number = $_REQUEST['Telephone_Number'];
$Case_Status = $_REQUEST['Case_Status'];
$Call_Notes = $_REQUEST['Call_Notes'];
$CallStartTime = $_REQUEST['CallStartTime'];

//adds to Calls table
$SQL_CallID = "SELECT MAX(`CallID`) FROM `Calls`";
if (mysqli_query($conn, $SQL_CallID)){
    $Previous_ID = mysqli_query($conn, $SQL_CallID);
    $Previous_ID = mysqli_fetch_array($Previous_ID);
    $Previous_ID = intval($Previous_ID[0]);
    $New_Call_ID = $Previous_ID + 1;
}
date_default_timezone_set('Europe/London');
$CallEndTime = date('Y-m-d H:i:s');
$sqlCalls = "INSERT INTO `Calls` (`CallID`, `CallerEmpID`, `OperatorEmpID`, `CallStartTime`, `CallEndTime`, `CallReason`) VALUES ($New_Call_ID, {$_POST['Caller_ID']}, 8, '{$CallStartTime}', '{$CallEndTime}', '{$Call_Notes}');";
$result = mysqli_query($conn, $sqlCalls);

mysqli_close($conn);

array_push($arr_data, $callsArray);
$jsonData = json_encode($arr_data,JSON_PRETTY_PRINT);
file_put_contents($jsonTest, $jsonData);
?>