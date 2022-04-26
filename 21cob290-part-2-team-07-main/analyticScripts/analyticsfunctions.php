<?php


$servername ="localhost";
$dbname = "testdatabase";
$username = "team007";
$password = "team007";

$conn = mysqli_connect($servername,$username,$password,$dbname);
if(!$conn){
  die("Connection failed: ". mysqli_connect_error());
}
//  echo "Connected Successfully","<br>";


/**
 * Given 2 dates in DateTime format 
 * counts the number of resolved cases.
 * 
 */
function countResolvedCases($conn,$startDate,$endDate){
  $query = "SELECT COUNT(cases.CaseStatus) 
  FROM cases 
  WHERE (cases.CaseStatus = 'Closed' OR cases.CaseStatus = 'Resolved') AND cases.TimeResolved
  BETWEEN '$startDate' AND '$endDate'";
  $result = mysqli_query($conn,$query);
  $resultArray = array();
  if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
      $resultArray[]=$row;
    }
  }
  echo $resultArray[0]["COUNT(cases.CaseStatus)"];
}


/**
 * given a caseID it returns the time it took to resolve the case in seconds.
 */
function getCaseResolveTime($conn,$caseID){
  $query = "SELECT CASES.CaseID,cases.Problem,.calls.CallID,calls.CallStartTime,cases.TimeResolved
  FROM callscases 
  INNER JOIN cases 
  ON callscases.CaseID = cases.CaseID
  INNER JOIN calls 
  ON callscases.CallID = calls.CallID
  WHERE cases.CaseID = '$caseID' AND cases.TimeResolved IS NOT NULL
  ORDER BY calls.CallStartTime LIMIT 1";

  $result = mysqli_query($conn,$query);
  $resultArray = array();
  if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
      $resultArray[]=$row;
    }
  }
  $startDateTime = new DateTime($resultArray[0]["CallStartTime"]);
  $endDateTime = new DateTime($resultArray[0]["TimeResolved"]);
  $timeDiff = $endDateTime->getTimestamp() - $startDateTime->getTimestamp();
  // echo "<br>",$timeDiff;
  return $timeDiff;

}

/**
 * calculates average case resolve time given 2 dates in DateTime format
 * Returns in D:H:M:S format
 */
function calcAvgCaseResolveTime2($conn,$startDate,$endDate){
  $query = "SELECT cases.CaseID, cases.TimeOpened,cases.TimeResolved 
  FROM cases WHERE cases.TimeResolved IS NOT NULL
   AND cases.TimeOpened BETWEEN '$startDate' AND '$endDate'";

  $result = mysqli_query($conn,$query);
  $resultArray = array();
  if(mysqli_num_rows($result)>0){
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
      $resultArray[]=$row;
    }
  }
  $sum=0;
  for($i = 0; $i < count($resultArray); $i++){
    $date2 = new DateTime($resultArray[$i]["TimeResolved"]);
    $date1 = new DateTime($resultArray[$i]["TimeOpened"]);
    $secondDiff = $date2->getTimestamp() - $date1->getTimestamp();
    $sum+=$secondDiff;
  }

  $avgSeconds = round($sum/count($resultArray));
  // echo "avgseconds",$avgSeconds,"<br>";
  $date3 = new DateTime("@0");
  $date4 = new DateTime("@$avgSeconds");
  $avgTime = date_diff($date3,$date4);
  $formatted= $avgTime->format('%a:%H:%I:%S');
  echo $formatted;

}


/**
 *calculates average case resolve time given 2 dates in DateTime format
 * Returns in D:H:M:S format
 */
function calcAvgCaseResolveTime($conn,$startDate,$endDate){
  $caseIDQuery = "SELECT cases.CaseID FROM cases
  WHERE cases.TimeResolved
  BETWEEN '$startDate' AND '$endDate'";

  $caseIDQueryResult = mysqli_query($conn,$caseIDQuery);
  $caseIDQueryResultArray =array();

  if(mysqli_num_rows($caseIDQueryResult)>0){
    while($row = mysqli_fetch_array($caseIDQueryResult, MYSQLI_ASSOC)){
      $caseIDQueryResultArray[]=$row;
    }
  }
  $sum=0;
  for($j=0; $j<count($caseIDQueryResultArray); $j++){
    // echo "case ID",$caseIDQueryResultArray[$j]["CaseID"],"<br>";
    $sum+= getCaseResolveTime($conn,$caseIDQueryResultArray[$j]["CaseID"]);
  }

  $avgSeconds = round($sum/count($caseIDQueryResultArray));
  // echo "avgSeconds ", $avgSeconds;
  // echo "<br>",$sum," SUM";

  $date0 = new DateTime("@0");
  $date1 = new DateTime("@$avgSeconds");
  $avgTime = date_diff($date0,$date1);
  $formatted= $avgTime->format('%a:%H:%I:%S');
  echo $formatted;
 

  // echo count($caseIDQueryResultArray);



}

/**
 * Calculates the mean call time between 2 dates given in DateTime format. 
 */
function calcAvgCallTime($conn,$startDate,$endDate){
    $callQuery = "SELECT calls.CallID,calls.CallStartTime,calls.CallEndTime FROM calls
    WHERE calls.CallStartTime 
    BETWEEN '$startDate' AND '$endDate' ";

    $callTimeResults = mysqli_query($conn,$callQuery);

    $callTimeResultsArray = array();

    if(mysqli_num_rows($callTimeResults)>0){
        while($row = mysqli_fetch_array($callTimeResults, MYSQLI_ASSOC)){
          $callTimeResultsArray[]=$row;
        }
      }

    // Debugging code to check for array contents
    // for($i=0; $i < count($callTimeResultsArray);$i++ ){
    //   echo $callTimeResultsArray[$i]["CallStartTime"]," - ",$callTimeResultsArray[$i]["CallID"]," - ", $callTimeResultsArray[$i]["CallEndTime"], "<br>";
    // }


    $sum=0;
    for($i=0; $i < count($callTimeResultsArray);$i++ ){
      $startDateTime = new DateTime($callTimeResultsArray[$i]["CallStartTime"]);
      $endDateTime = new DateTime($callTimeResultsArray[$i]["CallEndTime"]);
      $timeDiff = date_diff($startDateTime,$endDateTime);
      $hrs2Secs = intval($timeDiff->format('%H'))*60*60;
      $minutes2Secs = intval($timeDiff->format('%I')) *60;
      $secondsInt = intval($timeDiff->format('%S'));

      $sum += $hrs2Secs + $minutes2Secs + $secondsInt;

     
    }
   
    $avgSeconds = round($sum/(count($callTimeResultsArray)));
    $secs = round($avgSeconds % 60);
    $mins = (round($avgSeconds)-$secs)/60;

    if($secs<10){
      $secs = "0".strval($secs);
    }


    echo $avgCallTime = strval($mins).":".$secs;

}


/**
 * Given a problem type and 2 dates in DateTime format 
 * returns number of cases with that problem type. 
 */
function countProblemType($conn,$startDate,$endDate,$problemType){
  $query = "SELECT COUNT(cases.Problem) as total FROM cases
  WHERE cases.Problem ='$problemType' AND  cases.TimeOpened
  BETWEEN '$startDate' AND '$endDate'";

  $result = mysqli_query($conn,$query);
  $data = $result->fetch_assoc();
  echo $data['total'];

}

function countOpenCases($conn,$startDate,$endDate){
  $query = "SELECT COUNT(cases.CaseStatus) as total FROM cases
  WHERE cases.CaseStatus ='Open' AND  cases.TimeOpened
  BETWEEN '$startDate' AND '$endDate'";

  $result = mysqli_query($conn,$query);
  $data = $result->fetch_assoc();
  echo $data['total'];

}





















?>