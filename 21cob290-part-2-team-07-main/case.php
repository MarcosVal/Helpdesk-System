<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
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


    function some_func(){
      console.log("yes");
    }
    function toa($result){
      $emptyArray = array();
      if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
          array_push($emptyArray,$row);
        }
      }
      return $emptyArray;
    }



    // $priority = $_GET["case_priority"];
    // $problem_type = $_GET["problem_type"];
    $case_id = $_GET["case_id"];
    // $employee_id = $_GET["employee_id"];
    // $serial_number = $_GET["serial_number"];
    // $operating_system = $_GET["operating_system"];
    // $software = $_GET["software"];
    // $time_resolved = $_GET["time_resolved"];
    // $time_closed = $_GET["time_closed"];

    $operating_system_query = "SELECT OperatingSystem from cases where CaseID = $case_id";
    $operating_system = mysqli_fetch_row(mysqli_query($conn, $operating_system_query))[0];

    $software_query = "SELECT Software from cases where caseid = $case_id";
    $software = mysqli_fetch_row(mysqli_query($conn, $software_query))[0];

    $priority_query = "SELECT CasePriority from cases WHERE CaseID = $case_id";
    $priority = mysqli_fetch_row(mysqli_query($conn, $priority_query))[0];

    $problem_type_query = "SELECT ProblemType from cases WHERE CaseID = $case_id";
    $problem_type = mysqli_fetch_row(mysqli_query($conn, $problem_type_query))[0];

    $employee_id_query = "SELECT EmpID from cases WHERE caseID = $case_id";
    $employee_id = mysqli_fetch_row(mysqli_query($conn, $employee_id_query))[0];

    $serial_number_query = "SELECT SerialNumber FROM cases WHERE CaseID = $case_id";
    $serial_number = mysqli_fetch_row(mysqli_query($conn, $serial_number_query))[0];

    $time_closed_query = "SELECT TimeClosed from cases WHERE CaseID = $case_id";
    $time_closed = mysqli_fetch_row(mysqli_query($conn, $time_closed_query))[0];

    $time_resolved_query = "SELECT TimeResolved from cases WHERE CaseID = $case_id";
    $time_resolved = mysqli_fetch_row(mysqli_query($conn, $time_resolved_query))[0];

    $status_query = "SELECT CaseStatus from cases WHERE CaseID = $case_id";
    $status = mysqli_fetch_row(mysqli_query($conn, $status_query))[0];

    $desc_query = "SELECT CaseDescription from cases WHERE CaseID = $case_id";
    $desc = mysqli_fetch_row(mysqli_query($conn,$desc_query))[0];

    $resolution_query = "SELECT problemResolution from cases WHERE CaseID = $case_id";
    $resolution = mysqli_fetch_row(mysqli_query($conn,$resolution_query))[0];

    $time_open_query = "SELECT TimeOpened from cases where caseid = $case_id";
    $time_open = mysqli_fetch_row(mysqli_query($conn,$time_open_query))[0];

    $specialist_query = "SELECT employees.Name FROM cases
LEFT JOIN employees ON cases.EmpID = employees.EmpID
WHERE cases.EmpID = '$employee_id'
LIMIT 1";
    $specialist_name = mysqli_fetch_row(mysqli_query($conn,$specialist_query))[0];


    $audit_query = "SELECT employees.name, auditlog.CaseID, auditlog.TimeOfChange, auditlog.OldField, auditlog.NewField, auditlog.ChangedColumn, auditlog.EmpID FROM auditlog, employees WHERE auditlog.CaseID = $case_id AND employees.EmpID = auditlog.EmpID ORDER BY TimeOfChange DESC";
    $audit_query_result = mysqli_query($conn,$audit_query);

    $audit_result = toa($audit_query_result);
    $audit = json_encode($audit_result);

    $calls_query = "SELECT DISTINCT calls.CallID, calls.CallerEmpID, calls.OperatorEmpID, calls.CallStartTime, calls.CallEndTime, calls.CallReason,a.Name as 'Caller Name',b.Name as 'Operator Name'
    FROM callscases
    INNER JOIN cases
    ON callscases.CaseID = '$case_id'
    INNER JOIN calls
    ON callscases.CallID = calls.CallID
    INNER JOIN employees a
    ON calls.CallerEmpID = a.EmpID
    INNER JOIN employees b
    ON calls.OperatorEmpID = b.EmpID
    ";

    $calls_query_result = mysqli_query($conn, $calls_query);
    $calls_result = toa($calls_query_result);
    $calls = json_encode($calls_result);

    $spec_query = "SELECT employees.EmpID, employees.Name FROM `employees`
LEFT JOIN specialists ON employees.EmpID = specialists.EmpID
WHERE employees.Job = 'Specialist' AND specialists.Speciality LIKE '%$problem_type%'";
    $spec_result = mysqli_query($conn, $spec_query);
    $spec = toa($spec_result);

    for($i = 0; $i < count($spec); $i++){
      $empid = $spec[$i][0];
      $active_case_query = "SELECT COUNT(CaseID) FROM cases WHERE EmpID = $empid AND CaseStatus = 'Open'";
      $active_case_result = mysqli_query($conn,$active_case_query);
      $active_case = mysqli_fetch_row($active_case_result)[0];
      array_push($spec[$i], $active_case);
    }

    $spec = json_encode($spec);

    $arrays_of_fetched = array(
      0 => $status,
      1 => $priority,
      2 => $problem_type,
      3 => $case_id,
      4 => $employee_id,
      5 => $serial_number,
      6 => $operating_system,
      7 => $software,
      8 => $time_resolved,
      9 => $time_closed,
      10 => $desc,
      11 => $resolution,
      12 => $time_open,
      13 => $specialist_name
    );

    ?>
    <script>
    var case_info = <?php echo json_encode($arrays_of_fetched); ?>;
    var audit_log = <?php echo $audit ?>;
    var calls = <?php echo $calls ?>;
    var spec = <?php echo $spec ?>;
    var op_id = <?php echo $log_id ?>;
    var job = <?php echo json_encode($job) ?>;
    // console.log(job);
    // console.log(audit_log);


    function check_null(info){
      if(case_info[5] == null){
        document.getElementById("serial_case").innerHTML = "N/a";
      }
      else{
        document.getElementById("serial_case").innerHTML = case_info[5];
      }
    }
    document.addEventListener("DOMContentLoaded", function(event){
      var elms = document.getElementById("case_header").getElementsByTagName("h1");
      elms[0].innerHTML = "Case Number: " + case_info[3];
      if(job == "Specialist"){
        document.getElementById("status_select").innerHTML = `
        <option value="Open">Open</option>
        <option value="Resolved">Resolved</option>
        `
      }
      else if(job == "Helpdesk Opoerator"){
        
      }
      // document.getElementById("case_info").getElementsByTagName("div")[0].innerHTML = `
      // <p>Case Status: `+ case_info[0]+`<br>Case Priority: `+case_info[1]+
      // `<br>Problem Type: `+case_info[2]+`<br>Case ID: `+case_info[3]+`
      // <br>Serial Number: `+case_info[5]+`<br>Operating System: `+case_info[6]+`
      // <br>Software: `+case_info[7]+`<br>Time Resolved: `+case_info[8]+`
      // <br>Time Closed: `+case_info[9]+`</p>
      // `

      var selected_value = document.getElementById("status_select")
      selected_value.value = case_info[0]

      var selected_value_priority = document.getElementById("priority_select")
      selected_value_priority.value = case_info[1]
      document.getElementById("status_case").innerHTML = case_info[0]
      document.getElementById("priority_case").innerHTML = case_info[1]
      document.getElementById("type_case").innerHTML = case_info[2];
      document.getElementById("id_case").innerHTML = case_info[3];
      document.getElementById("operating_system_case").innerHTML = case_info[6]
      document.getElementById("software_case").innerHTML = case_info[7];
      document.getElementById("time_resolved_case").innerHTML = case_info[8] == null ? "N/a" : case_info[8]
      document.getElementById("spec_case").innerHTML = case_info[13];

      document.getElementById("serial_case").innerHTML = case_info[5] == null ? "N/a" : case_info[5];

      document.getElementById("time_closed_case").innerHTML = case_info[9] == null ? "N/a" : case_info[9];


      document.getElementById("case_desc_p").innerHTML += case_info[10]

      document.getElementById("resolution_p").innerHTML += case_info[11]

      document.getElementById("time_open_case").innerHTML = `<p>`+case_info[12] == null ? "N/a" : case_info[12]+`<p>`

      audit_log.forEach(function(arr){
        document.getElementById("audit_table").innerHTML += `
        <tr>
        <td>`+arr[0]+`</td>
        <td>`+arr[1]+`</td>
        <td>`+arr[2]+`</td>
        <td>`+arr[3]+`</td>
        <td>`+arr[4]+`</td>
        <td>`+arr[5]+`</td>
        </tr>
        `
      })

      calls.forEach(function(arr){
        document.getElementById("calls_table").innerHTML += `
        <tr>
        <td>`+arr[0]+`</td>
        <td>`+arr[6]+`</td>
        <td>`+arr[7]+`</td>
        <td>`+arr[3]+`</td>
        <td>`+arr[4]+`</td>
        <td>`+arr[5]+`</td>
        </tr>
        `
      })

      spec.forEach(function(arr){
        document.getElementById("specialist_table").innerHTML += `
        <tr>
        <td>`+arr[0]+`</td>
        <td>`+arr[1]+`</td>
        <td>`+arr[2]+`</td>
        <td class ="clickable">Assign</td>
        </tr>
        `
      })
      var date = new Date();
      var date_time = "";

      date_time += date.getFullYear() + "-" + ('0' + (date.getMonth() + 1)).slice(-2) + "-" + date.getDate() + " " + ('0' + date.getHours()).slice(-2) + ":" + ('0' + date.getMinutes()).slice(-2) + ":" + ('0' + date.getSeconds()).slice(-2)
      var clicks = document.getElementsByClassName("clickable");

      for(var i = 0; i < clicks.length; i++){
        clicks[i].addEventListener("click",function(){

          var initial_spec = case_info[4]
          var row = this.closest('tr')
          var employee_id = row.querySelectorAll('td')[0].innerText
          if(initial_spec != employee_id){
            const request = new XMLHttpRequest()
            request.onload = function(){
              location.reload()
              console.log(this.responseText)
            }
            request.open("POST", "change.php",true)
            request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            request.send("employeeID="+employee_id+"&case_id="+case_info[3]+"&initial_spec="+initial_spec+"&time="+date_time+"&operator_id="+op_id)
          }

        })
      }
      document.getElementById("edit_desc").addEventListener("click",function(event){
        document.getElementById("edit_desc").style.filter = "invert(65%) sepia(16%) saturate(6635%) hue-rotate(62deg) brightness(95%) contrast(112%)";
        console.log(document.getElementById("case_desc_p").contentEditable)
        var initial_desc = case_info[10]
        console.log(document.getElementById("case_desc_p").innerText)

        if(document.getElementById("case_desc_p").contentEditable == "false"){

          document.getElementById("case_desc_p").contentEditable = true;
        }
        else if(document.getElementById("case_desc_p").contentEditable == "true"){
          document.getElementById("case_desc_p").contentEditable = false;
          var description = document.getElementById("case_desc_p").innerText
          const request = new XMLHttpRequest()
          request.onload = function(){
            location.reload()
            console.log(this.responseText)
          }
          request.open("POST", "change.php",true)
          request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          request.send("case_id="+case_info[3]+"&description="+description+"&time="+date_time+"&operator_id="+op_id+"&initial="+initial_desc)
        }
      })

      document.getElementById("edit_resolution").addEventListener("click",function(event){
        document.getElementById("edit_resolution").style.filter = "invert(65%) sepia(16%) saturate(6635%) hue-rotate(62deg) brightness(95%) contrast(112%)"
        var initial_resolution = case_info[11]
        console.log(document.getElementById("resolution_p").contentEditable)
        if(document.getElementById("resolution_p").contentEditable == "false"){
          document.getElementById("resolution_p").contentEditable = true
        }
        else if(document.getElementById("resolution_p").contentEditable == "true"){
          console.log("ye")
          document.getElementById("resolution_p").contentEditable = false;
          var resolution = document.getElementById("resolution_p").innerText;
          const requester = new XMLHttpRequest()
          requester.onload = function(){

            console.log(this.responseText)
            location.reload()
          }
          requester.open("POST", "change.php", true)
          requester.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
          requester.send("case_id="+case_info[3]+"&resolution="+resolution+"&time="+date_time+"&operator_id="+op_id+"&initial="+initial_resolution)
        }
      })
      document.getElementById("edit_image").addEventListener("click",function(event){
        document.getElementById("edit_image").style.filter = "invert(65%) sepia(16%) saturate(6635%) hue-rotate(62deg) brightness(95%) contrast(112%)";
        var initial_status = case_info[0]
        var initial_priority = case_info[1]

        var status_changed = false;
        var priority_changed = false;
        var date = new Date();
        var date_time = "";

        date_time += date.getFullYear() + "-" + ('0' + (date.getMonth() + 1)).slice(-2) + "-" + date.getDate() + " " + ('0' + date.getHours()).slice(-2) + ":" + ('0' + date.getMinutes()).slice(-2) + ":" + ('0' + date.getSeconds()).slice(-2)
        var status_display = document.getElementById("status_case").style.display
        var select_display = document.getElementById("status_select").style.display
        var priority_display = document.getElementById("priority_case").style.display
        var priority_select_display = document.getElementById("priority_select").style.display
        if(status_display != "none" && select_display != "block"){
          document.getElementById("status_case").style.display = "none"
          document.getElementById("status_select").style.display = "block"
        }
        else{
          var final_status = document.getElementById("status_select").value
          if(initial_status === final_status){
          }
          else{
            console.log("yes");
            status_changed = true;
            var final_status = document.getElementById("status_select").value
            const requesthttp = new XMLHttpRequest();
            if(final_status === "Closed"){
              document.getElementById("time_closed_case").innerHTML = date_time;

            }
            else if(final_status === "Resolved"){
              document.getElementById("time_resolved_case").innerHTML = date_time;
            }
            else{
              document.getElementById("time_closed_case").innerHTML = "N/a";
            }

            requesthttp.onload = function(){
              location.reload();
            }
            requesthttp.open("POST", "change.php",true);
            requesthttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            requesthttp.send("initial_status="+initial_status+"&status="+final_status+"&time="+date_time+"&caseID="+case_info[3]+"&employee_id="+op_id);
            document.getElementById("status_case").innerHTML = document.getElementById("status_select").value;
          }
          document.getElementById("status_case").style.display = "block"
          document.getElementById("status_select").style.display = "none"

        }

        if(priority_display !== "none" && priority_select_display !== "block"){
          document.getElementById("priority_case").style.display = "none"
          document.getElementById("priority_select").style.display = "block"
        }
        else{
          var final_priority = document.getElementById("priority_select").value
          if(initial_priority === final_priority){
          }
          else{
            priority_changed = true;
            var final_priority = document.getElementById("priority_select").value
            const requesthttp = new XMLHttpRequest();
            requesthttp.onload = function(){
              location.reload();

            }
            requesthttp.open("POST", "change.php",true);
            requesthttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            requesthttp.send("initial_priority="+initial_priority+"&priority="+final_priority+"&caseID="+case_info[3]+"&employee_id="+op_id+"&time="+date_time);
            document.getElementById("priority_case").innerHTML = document.getElementById("priority_select").value;
          }
          document.getElementById("priority_case").style.display = "block"
          document.getElementById("priority_select").style.display = "none"

        }


      })

      // document.getElementsByClassName("clickable").addEventListener("click", function(event){
      //
      // })
    })
    </script>
    <style>
    html, body{
      margin: 0;
      height: 100%;
    }
    h1{
      margin: 0;
      color: white;
      padding: 1%;
      font-family: Arial, Helvetica, sans-serif;
    }
      /* p{
      margin:0;
      padding-left: 10px;
      font-family: Arial, Helvetica, sans-serif;
      font-size: 1.2em;
    } */
    #case_header{
      width: 100%;
      height: 7%;
      padding-left: 100px;
      /* background-color: #3399ff; */
      background: radial-gradient(#3399ff,#004d99);
    }
    #case_info{
      width: 28%;
      height: 100%;
    }
    #assign_spec{
      width: 24%;
      height: 100%;
    }
    #first_container{
      width: 100%;
      height: 50%;
      display: flex;
    }
    #resolution{
      width: 24%;
      height: 100%;
    }
    #audit_log{
      height: 100%;
      width: 100%;
    }
    #case_desc{
      height: 100%;
      width: 24%
    }
    #second_container{
      width: 100%;
      height: 50%;
      display: flex;
    }
    .topic_header{
      background: radial-gradient(#3399ff,#004d99);
      width: 100%;
      height: 10%;
      margin: 0;
      background-color: #3399ff;
      color: white;
      border-radius: 2px;
      padding-left: 50px;
      outline-style: solid;
      font-family: Arial, Helvetica, sans-serif;
    }

    #calls, #specialist{
      height: 100%;
    }
    #calls{
      width: 50%;
    }
    #specialist{
      width: 20%;
    }
    .topic_body{
      background-image: linear-gradient(#ffffff, #bfbfbf);
      overflow: hidden;
      border-radius: 2px;
      outline-style: solid;
      outline-color: white;
      overflow: auto;
    }

    #audit_table, #case_info_table, #calls_table, #specialist_table{
      width: 100%;
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
    }

    #audit_table td, #audit_table th, #case_info_table th, #case_info_table, td, #calls_table td, #calls_table th, #specialist_table td, #specialist_table th{
      border-bottom: 1px solid #ddd;
      padding: 8px;
    }

    #audit_table tr:nth-child(even), #case_info_table tr:nth-child(even), #calls_table tr:nth-child(even), #specialist tr:nth-child(even){
      background-color: #f2f2f2;
    }

    #audit_table th, #case_info_table th, #calls_table th, #specialist_table th{
      padding-top: 12px;
      padding-bottom: 12px;
      background-color: #6AB0DE;
      text-align: left;
      color: white;
    }


    #edit_image, #edit_desc, #edit_resolution{
      width: 20px;
      height: 20px;
      padding-left: 50px;
      filter: invert(1);
      padding-top: 10px
    }

    #edit_image:hover {
      cursor: pointer;
      filter: invert(0);
    }

    #edit_desc:hover{
      cursor: pointer;
      filter: invert(0);
    }

    #status_select{
      display: none;

    }
    #priority_select{
      display: none;
    }
    #audit_table_scroll, #case_info_table_wrapper, #calls_table_wrapper, #specialist_table_wrapper{
      overflow-y: scroll;
      height: 90%;
    }
    #audit_table_scroll thead th, #calls_table_wrapper thead th, #specialist_table_wrapper thead th{
      position: sticky;
      top: 0;
      z-index: 1;
    }

    #audit_log,#calls{
      width: 100%;
    }

    .clickable:hover{
      cursor: pointer;
      text-decoration: underline;
    }

    /* #case_info_table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    } */
    /* #case_info_table{
      width: 100%;
      height: 100%;
      font-family: Arial, Helvetica, sans-serif;
      text-align: center;
    } */
    </style>
  </head>

  <body>
    <div id = "case_header" style="display: flex; flex-direction: row;">
    <a href="cases.php" style="text-decoration: none; color: white;"><h2><</h2></a>
    <h1></h1>
    </div>
  <div style="width: 80%; height: 80%; margin: auto;">
  <div id = "first_container">
  <div id = "case_info" class = "topic_body" style="overflow: hidden;">
    <div class = "topic_header" style="display: flex; background-color: #3399ff;">
    <h2 style="margin: 0;">Case Information</h2>
    <input id = "edit_image" type=image src=pencil.png alt="Submit feedback">
    </div>
    <div id = "case_info_table_wrapper">
      <table id = "case_info_table">
        <tr>
          <th>Case Status</th>
          <td><form method="post" action="change.php">
            <select id = "status_select" name = "stats">
              <option value="Open">Open</option>
              <option value="Resolved">Resolved</option>
              <option value="Closed">Closed</option>
            </select>
            <p id = "status_case"></p>
          </form></td>
        </tr>
        <tr>
          <th>Case Priority</th>
          <td><form action="">
            <select id = "priority_select">
              <option value="High">High</option>
              <option value="Medium">Medium</option>
              <option value="Low">Low</option>
            </select>
            <p id = "priority_case"></p>
          </form></td>
        </tr>
        <tr>
          <th>Assigned Specialist</th>
          <td id = "spec_case"></td>
        </tr>
        <tr>
          <th>Problem Type</th>
          <td id = "type_case"></td>
        </tr>
        <tr>
          <th>Case ID</th>
          <td id = "id_case"></td>
        </tr>
        <tr>
          <th>Serial Number</th>
          <td id = "serial_case"></td>
        </tr>
        <tr>
          <th>Operating System</th>
          <td id = "operating_system_case"></td>
        </tr>
        <tr>
          <th>Software</th>
          <td id = "software_case"></td>
        </tr>
        <tr>
          <th>Time Resolved</th>
          <td id = "time_resolved_case"></td>
        </tr>
        <tr>
          <th>Time Closed</th>
          <td id = "time_closed_case"></td>
        </tr>
        <tr>
          <th>Time Opened</th>
          <td id = "time_open_case"></td>
        </tr>
      </table>
    </div>
  </div>
  <div id = "case_desc" class = "topic_body" style="overflow: hidden;">
    <div class = "topic_header" style="display: flex; background-color: #3399ff;">
    <h2 style="margin:0;">Case Description</h2>
    <input id = "edit_desc" type=image src=pencil.png alt="Submit feedback">
  </div>
    <div>
      <p id = "case_desc_p" contenteditable="false"></p>
    </div>
  </div>
  <div id = "assign_spec" class = "topic_body" style="overflow: hidden;">
    <h2 class = "topic_header">Specialist Assignment</h2>
    <div id="specialist_table_wrapper">
      <table id = "specialist_table">
        <thead>
          <tr>
            <th>Employee ID</th>
            <th>Name</th>
            <th>Active Cases</th>
            <th>Assign</th>
          </tr>
        </thead>
      </table>
    </div>
  </div>

  <div id = "resolution" class = "topic_body" style="overflow: hidden;">
    <div class = "topic_header" style="display: flex; background-color: #3399ff;">
    <h2 style="margin:0;">Resolution</h2>
    <input id = "edit_resolution" type=image src=pencil.png alt="Submit feedback">
  </div>
    <div>
      <p id = "resolution_p" contenteditable="false"></p>
    </div>
  </div>
</div>
<div id = "second_container">
<div style="min-width: 50%">
<div id = "audit_log" class = "topic_body" style="outline-style: none; overflow: hidden;">
    <h2 class = "topic_header">Audit Log</h2>
    <div id="audit_table_scroll">
      <table id = "audit_table">
        <thead>
          <tr>
          <th>Employee</th>
          <th>Case ID</th>
          <th>Time Of Change</th>
          <th>Old Field</th>
          <th>New Field</th>
          <th>Changed Column</th>
          </tr>
        </thead>
      </table>
  </div>
</div>
</div>
<div id = "calls" class = "topic_body" style="overflow: hidden;">
  <h2 class = "topic_header">Calls</h2>
  <div id = "calls_table_wrapper">
    <table id = "calls_table">
      <thead>
        <tr>
          <th>Call ID</th>
          <th>Employee</th>
          <th>Operator</th>
          <th>Call Start Time</th>
          <th>Call End Time</th>
          <th>Call Reason</th>
        </tr>
      </thead>
    </table>
  </div>
</div>
<!-- <div id = "specialist" class = "topic_body" style="overflow: hidden;">
  <h2 class = "topic_header">Specialists</h2>
</div> -->
</div>
</div>
  </body>
</html>
