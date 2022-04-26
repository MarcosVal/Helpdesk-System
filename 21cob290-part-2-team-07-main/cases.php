<!DOCTYPE html>
<?php
require_once 'database.php';
session_start();
$log_id = $_SESSION["empID"];
$job = $_SESSION["Job"];

// echo $log_id;
// echo gettype($job);

$job_query = "SELECT Job from employees where EmpID = $log_id";
$job = mysqli_fetch_row(mysqli_query($conn, $job_query))[0];

$name_query = "SELECT name from employees where empid = $log_id";
$name = mysqli_fetch_row(mysqli_query($conn, $name_query))[0];
?>
<html>
<head>
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
<script>


// function buildingTable(searchInput){
//   var table = document.getElementById("caseTable")
//   document.getElementById("caseTable").innerHTML = ''
//   document.getElementById("caseTable").innerHTML += `<tr>
//       <th>Status</th>
//       <th>Case Priority</th>
//       <th>Problem Type</th>
//       <th>Case ID</th>
//       <th>Employee ID</th>
//       <th>Serial Number</th>
//       <th>Operating System</th>
//       <th>Software</th>
//       <th>Time Resolved</th>
//       <th>Time Closed</th>
//     </tr>
//     <tbody id = "testBody"></tbody>`;
//   const requesthttp = new XMLHttpRequest();
//   requesthttp.onload = function(){
//     // console.log(this.responseText);
//     const tableObj = JSON.parse(this.responseText);
//     tableObj.forEach(fillTab);
//   }
//   requesthttp.open("GET", "wholeTable.php",true);
//   requesthttp.send();
//   function fillTab(arr){
//     // console.log(typeof(arr[2]))
//     // console.log(arr[2])
//     if(searchInput.length != 0 && arr[2].toLowerCase().includes(searchInput.toLowerCase())){
//       // console.log("hell yes");
//       var statuscol = "green_stat";
//       if(arr[3] == "Open"){
//         statuscol = "green_stat";
//       }
//       else if(arr[3] == "Closed"){
//         statuscol = "red_stat";
//       }
//       else if(arr[3] == "In Progress"){
//         statuscol = "amber_stat";
//       }
//       else if(arr[3] == "Resolved"){
//         statuscol = "purple_stat";
//       }
//       if(arr[6] == null){
//
//         arr[6] = "N/a";
//       }
//       if(arr[8] == null){
//         arr[8] = "N/a";
//       }
//       if(arr[9] == null){
//         arr[9] = "N/a";
//       }
//       if(arr[10] == null){
//         arr[10] = "N/a";
//       }
//       var table = document.getElementById('testBody');
//       table.innerHTML += `
//       <tr class = "clickable">
//       <td><span class='case_stats' id=`+statuscol+`></span></td>
//       <td>`+arr[4]+`</td>
//       <td>`+arr[2]+`</td>
//       <td>`+arr[0]+`</td>
//       <td>`+arr[1]+`</td>
//       <td>`+arr[6]+`</td>
//       <td>`+arr[7]+`</td>
//       <td>`+arr[8]+`</td>
//       <td>`+arr[9]+`</td>
//       <td>`+arr[10]+`</td>
//       </tr>`
//     }
//
//   }
//
//
// }

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
// function onClickNewUser() {
//   location.replace("")
// }
function onClickTroubleshooting() {
  location.replace("generalTips.html")
}
function onClickLogOut() {
  location.replace("login.php")
}
function comparebuildingTable(){
  var table = document.getElementById("caseTable")
  document.getElementById("caseTable").innerHTML = `
  <thead>
      <tr>
      <th>Status</th>
        <th>Case Priority</th>
        <th>Problem Type</th>
        <th>Case ID</th>
        <th>Employee ID</th>
        <th>Serial Number</th>
        <th>Operating System</th>
        <th>Software</th>
        <th>Time Resolved</th>
        <th>Time Closed</th>
        <th>Time Opened</th>
      </tr>
      </thead>
      `
  const requesthttp = new XMLHttpRequest();
  requesthttp.onload = function(){
    // console.log(this.responseText);
    const tableObj = JSON.parse(this.responseText);
    tableObj.forEach(fillTab);
    var search_in = document.getElementById("caseSearchBar")
    var rows = document.getElementById("caseTable").querySelectorAll(".clickable")
    console.log(rows)
    search_in.addEventListener("keyup", function(event){
      const search_val = event.target.value.toLowerCase();
      rows.forEach(function(row){
        console.log(row.querySelectorAll("td")[2])
        row.querySelectorAll("td")[2].textContent.toLowerCase().startsWith(search_val)
        ? (row.style.display = "table-row")
        : (row.style.display = "none");
        row.querySelectorAll("td")[1].textContent.toLowerCase().startsWith(search_val)
        ? (row.style.display = "table-row")
        : (row.style.display = "none");
        row.querySelectorAll("td")[3].textContent.toLowerCase().startsWith(search_val)
        ? (row.style.display = "table-row")
        : (row.style.display = "none");
      })
    })
  }
  requesthttp.open("GET", "wholeTable.php",true);
  requesthttp.send();
  function fillTab(arr){
    var statuscol = "green_stat";
    if(arr[3] == "Open"){
      statuscol = "green_stat";
    }
    else if(arr[3] == "Closed"){
      statuscol = "red_stat";
    }
    else if(arr[3] == "In Progress"){
      statuscol = "amber_stat";
    }
    else if(arr[3] == "Resolved"){
      statuscol = "purple_stat";
    }
//     if(arr[6] == null){
//
//       arr[6] = "N/a";
// ;
//     }
//     if(arr[8] == null){
//       arr[8] = "N/a";
//     }
//     if(arr[9] == null){
//       arr[9] = "N/a";
//     }
//     if(arr[10] == null){
//       arr[10] = "N/a";
//     }

    console.log(typeof(arr[8]))
    document.getElementById("caseTable").innerHTML += `
    <tr class = "clickable">
    <td><span class='case_stats' id=`+statuscol+`></span></td>
    <td>`+(arr[4]== null  ? "N/a" : arr[4])+`</td>
    <td>`+(arr[2]== null  ? "N/a" : arr[2])+`</td>
    <td>`+(arr[0]== null  ? "N/a" : arr[0])+`</td>
    <td>`+(arr[1]== null  ? "N/a" : arr[1])+`</td>
    <td>`+(arr[6]== null  ? "N/a" : arr[6])+`</td>
    <td>`+(arr[7]== null  ? "N/a" : arr[7])+`</td>
    <td>`+(arr[8]== null  ? "N/a" : arr[8])+`</td>
    <td>`+(arr[9]== null  ? "N/a" : arr[9])+`</td>
    <td>`+(arr[10]==  null ? "N/a" : arr[10])+`</td>
    <td>`+(arr[12]== null  ? "N/a" : arr[12])+`</td>
    </tr>`
  }



}
// function giveCases(input){
//   if(input.length == 0){
//     comparebuildingTable();
//     return;
//   }
//   else{
//
//     buildingTable(input);
//     return;
//
//   }
// }

document.addEventListener("DOMContentLoaded", function(event){
  comparebuildingTable()
  var job = <?php echo json_encode($job)?>;
  var id = <?php echo json_encode($log_id)?>;
  var name = <?php echo json_encode($name)?>;
  console.log(job);
  console.log(id);
  console.log(name);
  document.getElementById("user_info").innerHTML = name+` : `+job;

  // function buildingTable(){
  //  var table = document.getElementById("caseTable")
  //  document.getElementsByClassName("caseTable").empty()
  //  document.getElementById("caseTable").innerHTML += `<tr>
  //      <th>Status</th>
  //      <th>Case Priority</th>
  //      <th>Problem Type</th>
  //      <th>Case ID</th>
  //      <th>Employee ID</th>
  //      <th>Serial Number</th>
  //      <th>Operating System</th>
  //      <th>Software</th>
  //      <th>Time Resolved</th>
  //      <th>Time Closed</th>
  //    </tr>
  //    <tbody id = "testBody"></tbody>`;
  // }






var clickables = document.getElementsByClassName('clickable');
// document.getElementById("editButtons").onclick = function(){
//   console.log(clickables.length);
// }






  // document.getElementById("logoutbtn").onclick = function(){
  //   location.replace("index.html");
  // }



  // document.getElementById("arrow_down").click(function(){
  //   document.getElementsByClassName("drop").style.display = "block";
  // });

  // comparebuildingTable()
  // setInterval(function(){
  //   comparebuildingTable()
  //   console.log("hello");
  // }, 1500);

  document.getElementById("caseTable").addEventListener('mouseenter', (e) => {
    var item_list = []
    for(var i=0; i < clickables.length; i++){
      clickables[i].onclick = function(){
        var row = this.closest('tr')
        var columns = row.querySelectorAll('td')
        columns.forEach(function(item,i){
          item_list.push(item.innerText)
          console.log(item.innerText)


        })
        console.log(item_list[1])
        location.replace("case.php?case_priority="+ item_list[1]+ "&problem_type="+item_list[2]+"&case_id="+item_list[3]+"&employee_id="+item_list[4]+"&serial_number="+item_list[5]+"&operating_system="+item_list[6]+"&software="+item_list[7]+
      "&time_resolved="+item_list[8]+"&time_closed="+item_list[9])
      }
    }



  })


  document.getElementById("slide").onclick = function(){
    if(document.getElementById("menu").style.display == ""){
      document.getElementById("menu").style.display = "block"
    }
    else{
      document.getElementById("menu").style.display = ""
    }
  };



// document.getElementById("caseSearchBar").onkeyup = function(){
//   comparebuildingTable()
// }


  document.getElementsByClassName("editbtn").onclick = function(){
    document.getElementsByClassName("editbtn")[0].innerHTML = "Save Edit";
  }


  // $(function(){
  //   $("td[colspan=10]").find("div:first").hide();
  //   $("#caseTable").click(function(event){
  //     event.stopPropagation();
  //     var target = $(event.target);
  //     if(target.closest("td").attr("colsan") > 1){
  //       target.slideUp();
  //     }
  //     else{
  //       target.closest("tr").next().find("div:first").slideToggle();
  //     }
  //
  //
  //   });
  //
  //
  //
  //
  //
  // });

  // $("#saveButtons").click(function(){
    // $("#editButtons").css({
    //   "display": "block"
    // });
    // $("#saveButtons").css({
    //   "display": "none"
    // })
    // $(".caseStatsClass").css({"display" : "block"})
    // $(".statSelector").css({"display" : "none"})

    // var columnCount = 0;
    // $('#caseTable tr:nth-child(1) td').each(function(){
    //   columnCount += 1;
    // })

    // for(var i = 0; i < columnCount/10; i++){

      // var numb = Number($("#caseTable tr td:nth-child(2)").eq(i).text())
      // var actual = numb - 1;
      //
      // console.log(String($(".statSelector").eq(i).find(":selected").text()) != "Please Select")
      // if($(".statSelector").eq(i).find(":selected").text() != "Please Select"){
      //   dummy[actual]['Case_Status'] = ($(".statSelector").eq(i).find(":selected").text());
      // }
      //
      // if($(".descClass").eq(i).text() != ''){
      //   dummy[actual]['Case_Notes'] = $(".descClass").eq(i).text();
      // }
      //
      //
      // if($(".caseNotesClass").eq(i).text() != ''){
      //   dummy[actual]['Case_Description'] = $(".caseNotesClass").eq(i).text();
      // }
      // if($(".solutionClass").eq(i).text() != ''){
      //   dummy[actual]['Case_Solution'] = $(".solutionClass").eq(i).text();
      // }

    // }
    // var table = document.getElementById("caseTable")
    // comparebuildingTable()
    // console.log($("#caseTable .caseStatsClass").eq(i).text())
    // console.log(dummy[14]['Case_Status'])
    // $("td[colspan=10]").find("div:first").hide();

  // })

  // $("#editButtons").click(function(){
  //   var tabRow = $(this).closest('tr')
  //   var intdex = tabRow.find("td:nth-child(2)").text();
  //   var index = Number(intdex) - 1;
  //   $(this).css({
  //     "display": "none"
  //   });
  //   $("#saveButtons").css({
  //     "display": "block"
  //   })
  //   $(".descClass").attr('contentEditable', 'true');
  //   $(".caseNotesClass").attr('contentEditable', 'true');
  //   $(".solutionClass").attr('contentEditable', 'true');
  //   $(".caseStatsClass").css({"display" : "none"})
  //   $(".statSelector").css({"display" : "block"})
  //
  //
  //
  // })

});











</script>
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

/* #avatar{
  border-radius: 10px;
  height: 30px;
  width: 30px;
  background-color: yellow;
} */


.drop{
  position: absolute;
  right: 0;
  z-index: 1;
  height: 20px;
  width: 80px;
  background-color: white;
}

/* #arrow_down{
  border: solid white;
  border-width: 0 3px 3px 0;
  float: right;
  padding: 3px;
  margin: 10px 10px 0 0;
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
} */

#slide:hover {cursor: pointer;}

/* #logoutbtn{
  height: 100%;
  width: 100%;
} */


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

#searchCase{
  height: 6%;
  width: 100%;
  background-color: #e9e9e9;
  overflow: hidden;
}

#searchCase a{
  height: 100%;
  width: 8%;
  float: left;
  display: block;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

#searchCase a:hover{
  background-color: #ddd;
  color: white;
}

#searchCase a.active{
  background-color: #2196F3;
  color: white;
}

#searchCase .searchContainer{
  float: right;
}

#searchCase .searchContainer button{
  float: right;
  padding: 6px 10px;
  margin-right: 16px;
  margin-top: 8px;
  background: #ddd;
  font-size: 17px;
  border: none;
  cursor: pointer;
}

#searchCase input[type=text]{
  padding: 6px;
  margin-top: 8px;
  font-size: 17px;
  border: none;
}
#searchCase .searchContainer button:hover{
  background: #ccc;
}

@media screen and (max-width: 600px) {
  .#searchCase .searchContainer {
    float: none;
  }
  .#searchCase a, .#searchCase input[type=text], .#searchCase .searchContainer button {
    float: none;
    display: block;
    text-align: left;
    width: 100%;
    margin: 0;
    padding: 14px;
  }
  .#searchCase input[type=text] {
    border: 1px solid #ccc;
  }
}

#caseTable{
  width: 100%;
  height: 100%;
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
}



#caseTable td, #caseTable th, #personnelTable td, #personnelTable th{
  border-bottom: 1px solid #ddd;
  padding: 8px;
}

#caseTable tr:nth-child(even), #personnelTable tr:nth-child(even){
  background-color: #f2f2f2;
}


#caseTable tr:hover, #personnelTable tr:hover {background-color: #ddd;}

#caseTable th, #personnelTable th{
  padding-top: 12px;
  padding-bottom: 12px;
  background-color: #6AB0DE;
  text-align: left;
  color: white;
}

.case_stats{
  height: 25px;
  width: 25px;
  border-radius: 50%;
  display: inline-block;
  background-color: #bbb;
}

#green_stat{
  background-color: #43D53A;
}

#red_stat{
  background-color: #E45746;
}

#purple_stat{
  background-color: purple;
}

#amber_stat{
  background-color: orange;
}

#caseTable td, th{
  width: auto;
}

#avatar{
  border-radius: 10px;
  height: 30px;
  width: 30px;
  background-color: yellow;
}


.drop{
  display: none;
  position: absolute;
  right: 0;
  z-index: 1;
  height: 20px;
  width: 80px;
  background-color: white;
}

/* #arrow_down{
  border: solid white;
  border-width: 0 3px 3px 0;
  float: right;
  padding: 3px;
  margin: 10px 10px 0 0;
  transform: rotate(45deg);
  -webkit-transform: rotate(45deg);
} */

#slide:hover {cursor: pointer;}
/*
#logoutbtn{
  height: 100%;
  width: 100%;
} */

#personnelTable{
  display: none;
  width: 100%;
}
/*
#personnelTable th, td{
  min-width: 25%;
} */

#caseTable th:last, td:last{
  width: 2%;
}


.newCallText{
  color: white;
}

.menuImg:hover {cursor: pointer;}

.clickable:hover {cursor: pointer;}

#caseTable-scroller{
  overflow-y: scroll;
  max-height: 70%;
  width: 100%;
}

#caseTable-scroller thead th{
  position: sticky;
  top: 0;
  z-index: 1;
}
body{
  overflow: hidden;
}
</style>

</head>
<body>
<!-- <div id=slider><img src="logo.png" style="height: 34px; float: left;">
  <h5 style="float: left; line-height: -100px; margin: 10px 0 0 0; color: white; padding-left: 10px;">Make-It-All Helpdesk Service</h5>
  <img id=slide src="menu.png" style="height: 30px; padding-right: 205px;">
  <span id=arrow_down></span>
  <span id=avatar class=case_stats style="float: right; margin: 1px 10px 0 0; vertical-align: center;"><p style="margin: 0; padding-top: 5px;">A</p></span>
  <div class=drop>
    <button id=logoutbtn>LOG OUT</button>
  </div>

</div>
<div id=menu style="padding-bottom: 30px;">
  <table id=menuTable>
    <tr style="height: 50%;">
      <th><a href="#caseTable"><img src="dashboard.png" alt="dashboard" class=menuImg></th>
      <th><img src="analytics.png" class=menuImg id="analyticsImg"></th>
      <th><img src="phone.png" class=menuImg id="callImg"></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
    <tr>
      <th><b class="menuText" style="color: #FFF66B">Dashboard</b></th>
      <th><b class="menuText">Analytics</b></th>
      <th><b class="newCallText">New Call</b></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th></th>
    </tr>
    </table>
</div> -->

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

<div id=cases>
<div id=searchCase>
  <div style="float: right;" class="searchContainer">

    <form style="float: left;">

    <button style="float: right;"type="submit">search</button>
    <input style="float: left;" id="caseSearchBar" type="text" placeholder="Search Cases" name="search">
  </form>
  </div>
</div>
<div id="caseTable-scroller">
<table id=caseTable>
    <thead>
    <tr>
      <th>Status</th>
      <th>Case No.</th>
      <th>Case Type</th>
      <th>Caller</th>
      <th>Hardware Serial Number</th>
      <th>Software</th>
      <th>Operating System</th>
      <th>Date of Call</th>
      <th>Operator</th>
      <th>Telephone Number</th>
    </tr>
  </thead>
</table>
</div>
</div>
</body>
</html>
