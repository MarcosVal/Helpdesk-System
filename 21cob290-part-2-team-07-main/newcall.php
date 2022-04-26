<?php
include_once 'dbconnect.php';

session_start();
$_SESSION["start"] = date('y-m-d h:i:s');
$_SESSION["additional_case"] = false;
// $start = date('y-m-d h:i:s');
// setcookie("start", $start, time()+30*24*60*60);
//setcookie("additional_case", false, time()+30*24*60*60);
//include "pageNavigation.html"

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<!-- <script>

    window.onload = function(){
         window.open("http://35.195.15.199/21cob290-part-2-team-07-main/case.php?case_id=6", "_blank"); // will open new tab on window.onload
    }
</script> -->
<!-- <script>
    window.open("35.195.15.199/21cob290-part-2-team-07-main/case.php?case_id=6");
</script> -->
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


#slide:hover {cursor: pointer;}



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

input[id=switch] {
  width: 100%;
  background-color: #2d40eb;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 17px;
  font-family: Arial, Helvetica, sans-serif;
}

textarea[id=description] {
  height: 150px;
  width: 100%;
}

textarea[id=reason] {
  height: 150px;
  width: 100%;
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
// function onClickNewUser() {
//   location.replace("https://google.com")
// }
function onClickTroubleshooting() {
  location.replace("generalTips.html")
}
function onClickLogOut() {
  location.replace("login.php")
}

</script>

<div class = "header">
    <h1>Log Call</h1>
</div>

<form name="form" id="form" method="post" action="insert.php">
    <input name="switch" id="switch" type="reset" value="New Case?" onclick="window.location.href='newcase.php'">
    <br>

    <label for="operator">Operator:</label>
    <select id="operator" name="operator">
        <option value="N/A">>Choose Operator<</option>
        <?php
        $query = "SELECT * FROM employees WHERE Job = 'Helpdesk Operator';";
        $operators = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($operators)){
            echo "<option value=".$row['EmpID'].">".$row['Name']."</option>";}
        ?>
    </select>
    <br>

    <label for="caseID">Case ID:</label>
    <select id="caseID" name="caseID">
        <option value="N/A">>Choose Case<</option>
        <?php
        $query = "SELECT CaseID FROM cases;";
        $cases = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($cases)){
            echo "<option value=".$row['CaseID'].">".$row['CaseID']."</option>";}
        ?>
    </select>
    <br>

    <label for="caller">Caller Name:</label>
    <select id="caller" name="caller">
        <option value="N/A">>Choose Name<</option>
        <?php
        $query = "SELECT * FROM employees;";
        $callers = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($callers)){
            echo "<option value=".$row['EmpID'].">".$row['Name']."</option>";}
        ?>
    </select>
    <br>
    
    <label for="caller_ID">Caller ID:</label>
    <input type="text" id="caller_ID" name="caller_ID">
    <br>

    <script>
        let input = document.querySelector('#caller');
        input.addEventListener('change', function () {
          document.getElementById('caller_ID').value = this.value;
        });
    </script>



    <label for="reason">Reason for call:</label>
    <textarea id="reason" name="reason"></textarea>
    <br>
    <br>
    
    <input name="reset" id="reset" type="reset" value="Reset">
    <input name="new_call" id="submit" type="submit" value="Log Call">
    
</form>


</body>
</html>
