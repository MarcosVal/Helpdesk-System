<?php
require_once 'database.php';
// if(isset($_POST['caseID'])){
//   $id = $_POST['caseID'];
// }
// if(isset($_POST['time'])){
//   $time = $_POST['time'];
//   echo $time;
// }
if(isset($_POST['status'])){
  $status = $_POST['status'];
  $time = $_POST['time'];
  $id = $_POST['caseID'];
  $emp_id = $_POST['employee_id'];
  $initial_status = $_POST['initial_status'];
  if($status == "Closed"){

      $update_status = "UPDATE cases SET CaseStatus = '$status', TimeClosed = '$time' WHERE CaseID = '$id'";

  }
  else if($status == "Resolved"){
      $update_status = "UPDATE cases SET CaseStatus = '$status', TimeResolved = '$time' WHERE CaseID = '$id'";
  }
  else if($status == "Open"){
    $update_status = "UPDATE cases SET CaseStatus = '$status', TimeOpened = '$time', TimeResolved = Null, TimeClosed = Null WHERE CaseID = '$id'";
  }
  else if($status != "Open"){
    $update_status = "UPDATE cases SET CaseStatus = '$status', TimeOpened = NULL WHERE CaseID = '$id'";
  }
  else if($status != "Resolved"){
      $update_status = "UPDATE cases SET CaseStatus = '$status', TimeResolved = NULL WHERE CaseID = '$id'";
  }
  else{
      $update_status = "UPDATE cases SET CaseStatus = '$status', TimeClosed = NULL WHERE CaseID = '$id'";
  }

  $add_audit = "INSERT INTO auditlog (EmpID, CaseID, TimeOfChange, OldField, NewField, ChangedColumn) VALUES ('$emp_id', '$id','$time','$initial_status','$status', 'CaseStatus')";
  if(mysqli_query($conn,$update_status) && mysqli_query($conn, $add_audit)){
    echo "record updated successfully";
  }
  else{
    echo "failed";
  }
  echo $status;
}


if(isset($_POST['priority'])){
  $emp_id = $_POST['employee_id'];
  $time = $_POST['time'];
  $initial_priority = $_POST['initial_priority'];
  $priority = $_POST['priority'];
  $id = $_POST['caseID'];
  $update_priority = "UPDATE cases SET CasePriority = '$priority' WHERE CaseID = '$id'";
  $priority_audit = "INSERT INTO auditlog (EmpID, CaseID, TimeOfChange, OldField, NewField, ChangedColumn) VALUES ('$emp_id', '$id','$time','$initial_priority','$priority', 'CasePriority')";

  if(mysqli_query($conn,$update_priority) && mysqli_query($conn, $priority_audit)){
    echo "record updated successfully";
  }
  else{
    echo "failed";
  }
  echo $priority;
}

if(isset($_POST['employeeID'])){
  $initial_spec = $_POST['initial_spec'];
  $employeeID = $_POST['employeeID'];
  $case_id = $_POST['case_id'];
  $time = $_POST['time'];
  $operator_id = $_POST['operator_id'];

  $update_spec = "UPDATE cases SET EmpID = '$employeeID' WHERE CaseID = '$case_id'";
  $audit_log = "INSERT INTO auditlog (EmpID, CaseID, TimeOfChange, OldField, NewField, ChangedColumn) VALUES ('$operator_id', '$case_id','$time','$initial_spec','$employeeID', 'Specialist')";
  if(mysqli_query($conn,$update_spec) && mysqli_query($conn, $audit_log)){
    echo "record updated";
  }
  else{
    echo "failed";
  }


}

if(isset($_POST['description'])){
  $case_id = $_POST['case_id'];
  $initial_description = $_POST['initial'];
  $description = $_POST['description'];
  $operator_id = $_POST['operator_id'];
  $time = $_POST['time'];

  $update_description = "UPDATE cases SET CaseDescription = ? WHERE CaseID = $case_id";

  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $update_description)){
    echo "statement failed";
  }
  else{
    mysqli_stmt_bind_param($stmt, "s", $description);
    mysqli_stmt_execute($stmt);
  }

  $audit_log = "INSERT INTO auditlog (EmpID, CaseID, TimeOfChange, OldField, NewField, ChangedColumn) VALUES ('$operator_id', '$case_id','$time',?,?, 'Description')";
  $stmt2 = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt2, $audit_log)){
    echo "statement failed";
  }
  else{
    mysqli_stmt_bind_param($stmt2, "ss", $initial_description, $description);
    mysqli_stmt_execute($stmt2);
  }
  // if(mysqli_query($conn,$update_description) && mysqli_query($conn, $audit_log)){
  //   echo "record updated";
  // }
  // else{
  //   echo "failed";
  // }
}

if(isset($_POST['resolution'])){
  $case_id = $_POST['case_id'];
  $initial_resolution = $_POST['initial'];
  $resolution = $_POST['resolution'];
  $operator_id = $_POST['operator_id'];
  $time = $_POST['time'];

  $update_resolution = "UPDATE cases SET problemResolution = ? WHERE CaseID = '$case_id'";
  $stmt = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $update_resolution)){
    echo "statement failed";
  }
  else{
    mysqli_stmt_bind_param($stmt, "s", $resolution);
    mysqli_stmt_execute($stmt);
  }
  $audit_log = "INSERT INTO auditlog (EmpID, CaseID, TimeOfChange, OldField, NewField, ChangedColumn) VALUES ('$operator_id', '$case_id','$time',?,?, 'Description')";
  $stmt2 = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt2, $audit_log)){
    echo "statement failed";
  }
  else{
    mysqli_stmt_bind_param($stmt2, "ss", $initial_resolution, $resolution);
    mysqli_stmt_execute($stmt2);
  }
  // if(mysqli_query($conn,$update_description) && mysqli_query($conn, $audit_log)){
  //   echo "record updated";
  // }
  // else{
  //   echo "failed";
  // }
}



?>
