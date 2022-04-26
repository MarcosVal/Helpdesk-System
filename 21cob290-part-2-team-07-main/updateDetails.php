<?php


$servername = "localhost";
$username = "team007";
$password = "team007";
$dbname = "testdatabase";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

function pwdMatch($password, $password2) {
  $result;
  if ($password !== $password2) {
    $result = true;
  }
  else {
    $result = false;
  }
  return $result;
}







function updateUser($conn, $empID, $name, $Dept, $Job, $phoneNumber, $external, $username, $password, $password2) {
  global $conn;
  if (empty($password)) {
    $sql = "UPDATE employees SET Name = '?', Dept = '?', Job = '?', TelephoneNumber = '?', External = ? WHERE EmpID = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        echo "error";
    }
    
    mysqli_stmt_bind_param($stmt, "ssssii", $name, $Dept, $Job, $phoneNumber, $external, $empID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
  }

  else {
    $sql1 = "UPDATE logins SET username = '?', password = '?' WHERE EmpID = ?;";
    $stmt1 = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt1, $sql1)) {
        echo "error";
    }
    $pwdHashed = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt1, "ssi", $username, $pwdHashed, $empID);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);
  }


}




if (isset($_POST["update"])) {
  $empID = $_POST["empID"];
  $name = $_POST["name"];
  $Dept = $_POST["Dept"];
  $Job = $_POST["Job"];
  $externalRaw = $_POST["external"];
  $phoneNumber = $_POST["phoneNumber"];
  if (!empty($_POST["external"])) {
    $external = 1;
  }
  global $external;
  $username = $_POST["username"];
  $password = $_POST["password"];
  $password2 = $_POST["password2"];

  if (pwdMatch($password, $password2) !== false) {
    echo "Passwords dont match";
  }
  else {
    updateUser($conn, $empID, $name, $Dept, $Job, $phoneNumber, $external, $username, $password, $password2);
  }

}
?>




<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


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

form {
    margin: 0 auto;
    width: 400px;
    border-radius: 5px;
    background-color: #e9e9e9;
    padding: 25px;
    font-family: Arial, Helvetica, sans-serif;
}


input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=number], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=date], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type=submit] {
  width: 100%;
  background-color: #32a852;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 17px;
  font-family: Arial, Helvetica, sans-serif;
}

input[type=reset] {
  width: 100%;
  background-color: #c03232;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 17px;
  font-family: Arial, Helvetica, sans-serif;
}

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

<script>

function onClickDashboard() {
  location.replace("cases.php")
}
function onClickAnalytics() {
  location.replace("analytics.php")
}
function onClickNewCall() {
  location.replace("newcase.php")
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


<div class = "header">
    <h1>Update User</h1>
</div>

<form action="updateDetails.php" method="post">
    <label for="empID">Employee ID</label>
    <input type="text" id="empID" name="empID" required>
    <br>
    <label for="Name">Name</label>
    <input type="text" id="name" name="name" required>
    <br>
    <label for="Dept">Department</label>
    <input type="text" id="Dept" name="Dept" required>
    <br>
    <label for="Job">Job Title</label>
    <input type="text" id="Job" name="Job" required>
    <br>
    <label for="Telephone Number">Telephone Number</label>
    <input type="text" id="phoneNumber" name="phoneNumber" required>
    <br>
    <label for="external">External Member? </label>
    <input type="checkbox" id="external" name="external">
    <br>
    <br>
    <label for="username">Name</label>
    <input type="text" id="username" name="username" >
    <br>
    <label for="Password">Password</label>
    <input type="text" id="password" name="password" >
    <br>
    <label for="PasswordReEnter">Re-enter Password</label>
    <input type="text" id="password2" name="password2" >
    <br>
    <input name="reset" id="submit" type="reset" value="Reset">
    <input name="update" id="submit" type="submit" value="Create User">
</form>


</body>
</html>

