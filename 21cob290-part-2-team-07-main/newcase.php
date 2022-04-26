<?php
include_once 'dbconnect.php';

session_start();
$_SESSION["start"] = date('y-m-d h:i:s');
// $start = date('y-m-d h:i:s');
// setcookie("start", $start, time()+30*24*60*60);

?>

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
    <input name="switch" id="switch" type="reset" value="Existing Case?" onclick="window.location.href='newcall.php'">
    <br>

    <label for="operator">Operator:</label>
    <select id="operator" name="operator">
      <option value="N/A">>Choose Operator<</option>
      <?php //get operators from database
      $query = "SELECT * FROM employees WHERE Job = 'Helpdesk Operator';";
      $operators = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($operators)){
        echo "<option value=".$row['EmpID'].">".$row['Name']."</option>";}
      ?>
    </select>
    <br>

    <label for="caller">Caller Name:</label>
    <select id="caller" name="caller">
      <option value="N/A">>Choose Name<</option>
      <?php //get employees from database
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
    <!-- Actively updates caller ID depending on caller name-->

    <label for="category">Category:</label>
    <select id="category" name="category">
        <option value="N/A">>Choose Category<</option>
        <option value="Hardware">Hardware</option>
        <option value="Software">Software</option>
        <option value="Network">Network</option>
        </select>
        <br>


    <label for="problem">Problem Type:</label>
    <select id="problem" name="problem">
      <option value="N/A">>Choose Problem<</option>
      <?php
      $query = "SELECT DISTINCT Speciality FROM specialists;";
      $problems = mysqli_query($conn, $query);
      while ($row = mysqli_fetch_assoc($problems)){
        echo "<option value=".$row['Speciality'].">".$row['Speciality']."</option>";}
      ?>
    </select>
    <br>

    <label for="description">Case description:</label>
    <textarea id="description" name="description"></textarea>
    <br>
    <br>


    <label for="specialist">Specialist:</label>
    <select id="specialist" name="specialist">
        <option value="N/A">Not Needed (resolved)</option>
        <?php //get specialists from database
        $query = "SELECT * FROM employees WHERE Job = 'Specialist' OR Job = 'External Specialist';";
        $specialists = mysqli_query($conn, $query);
        while ($row = mysqli_fetch_assoc($specialists)){
          echo "<option value=".$row['EmpID'].">".$row['Name']."</option>";}
        ?>
    </select>
    <br>

    <label for="priority">Priority:</label>
    <select id="priority" name="priority">
        <option value="N/A">>Choose Priority<</option>
        <option value="High">High</option>
        <option value="Medium">Medium</option>
        <option value="Low">Low</option>
        </select>
        <br>

    <label for="serial">Hardware Serial Number:</label>
    <input type="text" id="serial" name="serial">
    <br>

    <label for="software">Software:</label>
    <input type="text" id="software" name="software">
    <br>

    <label for="operating_system">Operating System:</label>
    <input type="text" id="os" name="os">
    <br>

    <label for="reason">Reason for call:</label>
    <textarea id="reason" name="reason"></textarea>
    <br>
    <br>
    

    <input name="reset" id="reset" type="reset" value="Reset">
    <input name="another_case" id="submit" type="submit" value="Log Case (+Another)">
    <input name="new_case" id="submit" type="submit" value="Log Case (Final)">
    
</form>


</body>
</html>
