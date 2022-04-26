<!<!DOCTYPE html>
<html>
<head>
  
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<style>
  /* * {
  border: solid red 1px;
} */
  html, body{
    margin: 0;
    height: 100%;
  }

#downCsv,#downCsv2{
  margin:auto;
  color: black;
}

#menu{
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






.mainPart{
  margin-top: 50px;
  border-top:25px;
  padding-top:25px;

  margin-left: 100px;
  border-left: 25px;
  padding-left: 100px;

  margin-right: 100px;
  border-right: 25px;
  padding-right: 100px;

  padding-bottom:50px;
  border-bottom:50px;
  margin-bottom:50px;
  background-color: rgb(136, 136, 136);

}
.menuText{
  color: white;
}
.menuImg{
  height: 90px;
}

}
.mainPart{
  display: grid;
  grid-template-columns: auto auto;
  grid-template-rows: auto auto auto auto;
  justify-content: space-evenly;
}
.dashboardCard{
  background-color: rgb(100, 100, 100);
  border-radius: 25px;
  padding: 5px;
  margin-bottom:5px;

}
.cardTitle{
  color: rgb(175,175,175);
  text-align:center;
}
.cardValue{
  color: white;
  text-align: center;
}
.graphPart{
  background-color:rgb(136, 136, 136);
  padding:150px;
  border-radius: 25px;
  display:grid;
  grid-template-columns: auto auto;
  grid-template-rows:auto auto auto;
  column-gap:10px;
  row-gap: 20px;
  justify-content: space-evenly;

}
.graphBox{
  display: inline-block;

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

#cases{
  height: 100%;
  width: 100%;
  background-color: white;
  display: block;
  position: relative;
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


#avatar{
  border-radius: 10px;
  height: 30px;
  width: 30px;
  background-color: yellow;
}


.drop{
  position: absolute;
  right: 0;
  z-index: 1;
  height: 20px;
  width: 80px;
  background-color: white;
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
  <span id=arrow_down></span>
  <span id=avatar class=case_stats style="float: right; margin: 1px 10px 0 0; vertical-align: center;"><p style="margin: 0; padding-top: 5px;">A</p></span>
  <div class=drop>
    <button id=logoutbtn onclick="onClickLogOut()">LOG OUT</button>
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
  location.replace("newcall.php")
}
function onClickAdminPage() {
  location.replace("adminNav.php")     /* <-- Set redirect URL's here */
}
function onClickNewUser() {
  location.replace("newUser.php")
}
function onClickTroubleshooting() {
  location.replace("generalTips.html")
}
function onClickLogOut() {
  location.replace("login.php")
}

</script>
  <div class=mainPart>
  <script src="analyticScripts/analytic.js">
      </script>
      <?php
      include 'analyticScripts/connect.php';
      ?>
    <div>
      <div class=dashboardCard>
        <p class=cardTitle>Sort By: </p>
        <form action="analytics.php" method="get" id="timeSelect">
          <input type= "radio" id="30Days" name="specifiedTime" value=30>
          <label for="30Days">Past 30 Days</label><br>
          <input type= "radio" id="90Days" name="specifiedTime" value=90>
          <label for="90Days">Past 90 Days</label><br>
          <input type= "radio" id="allTime" name="specifiedTime" value=1000>
          <label for="allTime">All Time</label><br>
          <input type="submit" name="submit" id="submit" value="Submit">
          <button type="button" id="chartRadioButton" onclick="getDatedCaseData2()">Submit for Chart Data</button>
        </form>
      </div>
      <!-- <script src="analytics.js"></script> -->
      <!-- <script src="analyticScripts/analytic.js">
      </script> -->
      

    </div>
    <div class=analyticsGrid id=dateInputting>
      <div class=dashboardCard>
        <p class=cardTitle>Choose Start Date</p>
        <form action="analytics.php" method="get" id="daterange">
          <label for="start">Start Date</label>
          <input type ="date" id ="start" name ="startDate" min="2021-01-01" max="2022-12-31" value=<?php
          if (isset($_GET["startDate"])==false){
            echo "2021-01-01";
          }else{
            $test = $_GET['startDate'];
          echo $test;
          }
          ?>><br>
          <label for="end">End Date&nbsp;</label>
          <input type ="date" id ="end" name ="endDate" min="2021-01-01" max="2024-01-01" value=<?php
          if (isset($_GET["endDate"])==false){
            echo "2022-06-05";
          }else{
          $test2 = $_GET['endDate'];
          echo $test2;
          }
          ?>>
          <input type="submit" name="submitDates" id="submitDates" value="SubmitDates">
          <button type="button" id="chartButton" onclick="getDatedCaseData()">Submit for Chart Data</button>
        </form>
        <?php

        if(isset($_GET["specifiedTime"])){
            $test = $_GET["specifiedTime"];
            date_default_timezone_set("Europe/London");
            $endDate = date('Y-m-d');
            $startDate = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - $test, date("Y")));
            // echo $startDate, "<br>";
            // echo $endDate;
        }
        elseif(isset($_GET["startDate"]) && isset($_GET["endDate"])){
        $startDate= $_GET["startDate"];
        $endDate = $_GET["endDate"];


        // echo $startDate, "<br>";
        // echo $endDate;
        }elseif((isset($_GET["startDate"]) || isset($_GET["endDate"]))==false){
          $endDate = date('Y-m-d');
          $startDate = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 120, date("Y")));
        }else {
          $endDate = date('Y-m-d');
          $startDate = date('Y-m-d', mktime(0, 0, 0, date("m") , date("d") - 120, date("Y")));
        }
        ?>
      </div>
    </div>

    <div class=analyticsGrid id=avgCallTime>
      <div class=dashboardCard>
        <p class=cardTitle>Average Call Time</p>
        <p class=cardValue>
          <?php
          include "analyticScripts/analyticsfunctions.php";
          calcAvgCallTime($conn,$startDate,$endDate);
          ?>
        </p>
      </div>
    </div>
    <div class=analyticsGrid id=caseResolveTime>
      <div class=dashboardCard>
        <p class=cardTitle>Average Case Resolve Time (Days:Hours:Mins:Sec)</p>
        <p class=cardValue id =caseResolveTime2>
          <?php
          calcAvgCaseResolveTime2($conn,$startDate,$endDate);
          ?>
        </p>
      </div>

    </div>
    <div class=analyticsGrid id = unsolvedCases>
      <div class=dashboardCard>
        <p class=cardTitle>Unsolved Cases</p>
        <p class=cardValue>
          <?php
          countOpenCases($conn,$startDate,$endDate);
          ?>
        </p>
      </div>
    </div>
    <div class=analyticsGrid id=serverUptime>
      <div class=dashboardCard>
        <p class=cardTitle>Networking Issues</p>
        <p class=cardValue><?php
          countProblemType($conn,$startDate,$endDate,"Network");

        ?></p>
      </div>
    </div>
    <div class=analyticsGrid id=hwProblems>
      <div class=dashboardCard>
        <p class=cardTitle>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Hardware Issues&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        </p>
        <p class=cardValue>
          <?php
          countProblemType($conn,$startDate,$endDate,"Hardware");
          ?>
        </p>
      </div>
  </div>
  <div class=analyticsGrid id=swProblems>
    <div class=dashboardCard>
      <p class=cardTitle>Software Issues</p>
      <p class=cardValue>
      <?php
          countProblemType($conn,$startDate,$endDate,"Software");
          ?>
      </p>
    </div>
  </div>
  <div class=analyticsGrid id=expertAvailable>
    <div class=dashboardCard>
      <p class=cardTitle>Download Case Data as csv File</p>
      <button class=cardValue id="downCsv2">Download</button>
    </div>
  </div>
  <div class=analyticsGrid id=downloadCsv>
    <div class=dashboardCard>
      <p class=cardTitle>Download Call Data as csv File</p>
      <button class=cardValue  id="downCsv" >Download</button>
    </div>
  </div>
  </div>


  </div>
  </div>
  <div class = graphPart>
    <!-- <script type="text/javascript" src="analytics.js"></script> -->

    <div class = graphBox id="chart_div" style="width: 700px; height: 400px"></div>
    <div class = graphBox id ="chart_div2" style="width: 700px; height: 400px"></div>
    <div class = graphBox id ="chart_div3" style ="width: 700px; height: 400px"></div>
    <div class = graphBox id="softwareBarChart"></div>
    <div class = graphBox id="hardwareBarChart"></div>
    <div class = graphBox id="departmentPieChart"></div>
    <div class = graphBox id="barchart_material"></div>
  </div>






</body>
</html>
