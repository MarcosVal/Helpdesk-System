<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<style>
html, body{
    margin: 0;
    height: 100%;
  }
#menu, #slider {
    text-align: center;
    background-color: #686868;
  }

#slider{
  position: relative;
}
#menu{
  background-color: #4D4D4D;
}

#menu {
    padding: 10px;
    height: 12%;
    width: 100%;
  }

#menuTable{
  width: 100%;
  height: 100%;
  overflow: hidden;
  table-layout: fixed;
}

.menuText{
  color: white;
}
.menuImg{
  height: 90px;
}

#pageContent{
  height: 12%;
  width: 100%;
  background-color: #353535;
}


.button{
  height: 70%;
  width: 10%;
  display: inline-block;
  margin-left: 50px;
  margin-top: 15px;
  color: white;
  border-radius: 20px;
}


#arrow_down{
  border: solid white;
  border-width: 0 3px 3px 0;
  float: right;
  padding: 3px;
  margin: 10px 10px 0 0;
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
}

#slide:hover {cursor: pointer;}

#logoutbtn{
  height: 100%;
  width: 100%;
}


.activePageText{
  color: #FFF66B;
}

.menuImg:hover {cursor: pointer;}

.header {

  padding: 1px;
  text-align: center;
  background: #6ab0de;
  color: white;
  font-size: 10px;
  font-family: Arial, Helvetica, sans-serif;
}


</style>

</head>
<body>
  <div id=slider><img src="logo.png" style="height: 34px; float: left;">
    <h5 style="float: left; line-height: -100px; margin: 10px 0 0 0; color: white; padding-left: 10px;">Make-It-All Helpdesk Service</h5>
    <img id=slide src="menu.png" style="height: 30px; padding-right: 205px;">
    <div>
      <h4 id = "user_info" style="margin:0;color:white;"></h5>
    </div>

  </div>
  <div id=menu style="padding-bottom: 30px;">
    <table id=menuTable>
      <tr style="height: 50%;">
        <th><img src="dashboard.png" alt="dashboard" class='menuImg' id='dashboardImg' onclick="onClickDashboard()"></th>
        <th><img src="analytics.png" alt="analytics" class='menuImg' id='analyticsImg' onclick="onClickAnalytics()"></th>
        <th><img src="phone.png" alt="calls" class='menuImg' id='callImg' onclick="onClickNewCall()"></th>
        <th><img src="troubleshooting.png" alt="troubleshooting" class='menuImg' id='troubleshootingImg' onclick="onClickTroubleshooting()"></th>
        <th><img src="admin.png" alt="admin" class='menuImg' id='adminImg' onclick="onClickAdminPage()"></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><img src="logoutImg.png" class="menuImg" onclick="onClickLogOut()"></th>

      </tr>
      <tr>
        <th><b class="menuText">Dashboard</b></th>
        <th><b class="menuText">Analytics</b></th>   <!--Change class='menuText' to 'activePageText' on per page basis. --->
        <th><b class="menuText">New Call</b></th>
        <th><b class="menuText">Troubleshooting</b></th>
        <th><b class="menuText">Admin Settings</b></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th></th>
        <th><b class="menuText">Logout</b></th>
      </tr>
      </table>
  </div>

<div class = "header">
    <a href="newUser.php">
        <h1>New User</h1>
    </a>
</div>

<div class = "header">
    <a href="updateDetails.php">
        <h1>Update User</h1>
    </a>
</div>

<div class = "header">
    <a href="editSpecialties.php">
        <h1>Add Specialties</h1>
    </a>
</div>

<script>

function onClickDashboard() {
  location.replace("cases.php")
}
function onClickAnalytics() {
  location.replace("analytics.php")
}
function onClickNewCall() {
  location.replace("newcall.php")
}

function onClickAdminPage() {
  location.replace("adminNav.php")     /* <-- Set redirect URL's here */
}
function onClickTroubleshooting() {
  location.replace("generalTips.html")
}
function onClickLogOut() {
  location.replace("login.php")
}

</script>


</body>

</html>

<?php
session_start();

$servername = "localhost";
$username = "team007";
$password = "team007";
$dbname = "testdatabase";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
die("Connection failed: " . mysqli_connect_error());}

$id = $_SESSION["empID"];


function checkAdmin($conn, $id) {
  global $conn;
  $sql = "SELECT * FROM employees WHERE EmpID = ?;";
  $stmt = mysqli_stmt_init($conn);
  if (!mysqli_stmt_prepare($stmt, $sql)) {
    echo "error";
  }
  
  mysqli_stmt_bind_param($stmt, "i", $id);
  mysqli_stmt_execute($stmt);

  $resultData = mysqli_stmt_get_result($stmt);
  $row = mysqli_fetch_assoc($resultData);
  if ($row["Job"] == "ADMIN") {
    $valid = true;
  }
  else {
    $valid = false;
  }

  mysqli_stmt_close();
  return $valid;
}



if (!checkAdmin($conn, $id)) {
  header("location: cases.php");
  
}
