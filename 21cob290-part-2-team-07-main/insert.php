<?php
include_once 'dbconnect.php';

session_start();

//this increments the primary keys of cases and calls tables
$query = "SELECT CaseID FROM cases ORDER BY CaseID desc LIMIT 1;";
$latestid = mysqli_query($conn, $query);
$caseid = mysqli_fetch_row($latestid)[0] +1;

$query = "SELECT CallID FROM calls ORDER BY CallID desc LIMIT 1;";
$latestid = mysqli_query($conn, $query);
$callid = mysqli_fetch_row($latestid)[0] +1;




//inserting into database after submitting new case (including new call)
if (isset($_POST['new_case']) || isset($_POST['another_case'])) {
     if ($_SESSION["additional_case"]==false){
        //insert new case data
        $empid = $_POST['specialist'];
        $type = $_POST['problem'];
        $priority = $_POST['priority'];
        $desc = $_POST['description'];
        $serial = $_POST['serial'];
        $opsys = $_POST['os'];
        $software = $_POST['software'];
	$resolution = "";
        $opened = $_SESSION["start"];
        $category = $_POST['category'];
        if ($_POST['specialist'] == "N/A"){
            $status = "Resolved";
	    $insertion="INSERT INTO cases(TimeResolved) values($opened);";
	    if (mysqli_query($conn, $insertion)) {
           	 echo "New case has been added successfully !";
            } else {
            	echo "Error: " . $insertion . ":-" . mysqli_error($conn);
        	}
	    //if no specialist is needed then case is solved
        } else {
            $status = "Open";
	}

        $insertion = "INSERT INTO cases (CaseID,EmpID,ProblemType,CaseStatus,CasePriority,CaseDescription,
        SerialNumber,OperatingSystem,Software,TimeOpened,problemResolution,Problem)
        VALUES ('$caseid','$empid','$type','$status','$priority','$desc','$serial','$opsys','$software',
	'$opened','$resolution','$category');";
        if (mysqli_query($conn, $insertion)) {
            echo "New case has been added successfully !";
        } else {
            echo "Error: " . $insertion . ":-" . mysqli_error($conn);
        }

        //insert new call data
	$empid = $_POST['caller_ID'];
        $operator = $_POST['operator'];
        $start = $_SESSION["start"];
        $end = date('y-m-d h:i:s');
        $reason = $_POST['reason'];

        $insertion = "INSERT INTO calls (CallID,CallerEmpID,OperatorEmpID,CallStartTime,CallEndTime,CallReason)
        VALUES ('$callid','$empid','$operator','$start','$end','$reason');";
        if (mysqli_query($conn, $insertion)) {
            echo "New call has been added successfully !";
        } else {
            echo "Error: " . $insertion . ":-" . mysqli_error($conn);
        }
    //if an extra case is added in this call it will skip the previous insertions
    } else{
       $empid = $_POST['specialist'];
        $type = $_POST['problem'];
        $priority = $_POST['priority'];
        $desc = $_POST['description'];
        $serial = $_POST['serial'];
        $opsys = $_POST['os'];
        $software = $_POST['software'];
        $resolution = "";
        $opened = $_SESSION["start"];
        $category = $_POST['category'];
        if ($_POST['specialist'] == "N/A"){
            $status = "Resolved";
            $insertion="INSERT INTO cases(TimeResolved) values($opened);";
            if (mysqli_query($conn, $insertion)) {
                 echo "New case has been added successfully !";
            } else {
                echo "Error: " . $insertion . ":-" . mysqli_error($conn);
                }
        } else {
            $status = "Open";
        } 

	$insertion = "INSERT INTO cases (CaseID,EmpID,ProblemType,CaseStatus,CasePriority,CaseDescription,
        SerialNumber,OperatingSystem,Software,TimeOpened,problemResolution,Problem)
        VALUES ('$caseid','$empid','$type','$status','$priority','$desc','$serial','$opsys','$software',
        '$opened','$resolution','$category');";
        if (mysqli_query($conn, $insertion)) {
            echo "New case has been added successfully !";
        } else {
            echo "Error: " . $insertion . ":-" . mysqli_error($conn);
        }
        //the callID assigned to this new case in callscases will remain the same
        $callid = $callid -1;

    }

//inserting into database after submitting new call
} else if (isset($_POST['new_call'])) {
    $empid = $_POST['caller_ID'];
    $operator = $_POST['operator'];
    $start = $_SESSION["start"];
    $end = date('y-m-d h:i:s');
    $reason = $_POST['reason'];
    $caseid = $_POST['caseID'];

    $insertion = "INSERT INTO calls (CallID,CallerEmpID,OperatorEmpID,CallStartTime,CallEndTime,CallReason)
    VALUES ('$callid','$empid','$operator','$start','$end','$reason');";
    if (mysqli_query($conn, $insertion)) {
        echo "New call has been added successfully !";
     } else {
        echo "Error: " . $insertion . ":-" . mysqli_error($conn);
     }

} 

//connect primary keys appropriately in callscases table
$insertion = "INSERT INTO callscases (CallID,CaseID)
VALUES ('$callid','$caseid');";
if (mysqli_query($conn, $insertion)) {
    echo "New callcase has been added successfully !";
} else {
    echo "Error: " . $insertion . ":-" . mysqli_error($conn);
}
mysqli_close($conn);
?>

<?php
if (isset($_POST['another_case'])) {
    $_SESSION["additional_case"] =true;
    header("Location: newcase.php");
} else {
    $_SESSION["additional_case"] =false;
    header("Location: cases.php");
}
?>

<!-- <a href="case.php?case_id=3" target="_blank">Opens On Another Tab</a> -->
<!-- <head><script>window.open("case.php?case_id=3");</script></head> -->
