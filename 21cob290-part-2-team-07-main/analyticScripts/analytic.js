var casedata;
var calldata;
var specialistData;
//Request for Json for CSV file
var request = new XMLHttpRequest();
request.open('GET','analyticScripts/jsontest.php',true);
request.onload = function(){

var data =JSON.parse(this.response);
getValueArray(data);


function downloadCsvFile(){
    keyArray = getKeyArray(data);
    header = keyArray.join()+"\n";
    var csv = header;
    csvFileData = getValueArray(data);

    csvFileData.forEach(function(row){
        csv+=row.join(',');
        csv+="\n";
    });
    var hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'cases.csv';
    hiddenElement.click();
    console.log(hiddenElement);


}
var button2 = document.getElementById("downCsv2");
button2.addEventListener("click",downloadCsvFile);

}
request.send();


/**
 * 
 * @param {*} obj JSON 
 * @returns Values without Keys.
 */
function getValueArray(obj){
    var keyArray = Object.keys(obj);
    valueArray=[];
    for(var i = 0; i < keyArray.length; i++)
        valueArray.push(Object.values(obj[keyArray[i]]));

    return valueArray;


}


//Ajax request for callData for csv file
var callRequest = new XMLHttpRequest();
callRequest.open('GET','analyticScripts/callsjson.php',true);
callRequest.onload = function(){

calldata =JSON.parse(this.response);
getValueArray(calldata);
getKeyArray(calldata);

function downloadCsvFile(){
    // console.log("HELLO",calldata);
    keyArray = getKeyArray(calldata);
    header = keyArray.join()+"\n";
    var csv = header;
    csvFileData = getValueArray(calldata);

    csvFileData.forEach(function(row){
        csv+=row.join(',');
        csv+="\n";
    });
    var hiddenElement = document.createElement('a');
    hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);
    hiddenElement.target = '_blank';
    hiddenElement.download = 'calls.csv';
    hiddenElement.click();

}
var button1 = document.getElementById("downCsv");
button1.addEventListener("click",downloadCsvFile);
    
    }
   
callRequest.send();


//draws Bar and Line charts on page load
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.load('current', {packages: ['corechart', 'line']});

google.charts.setOnLoadCallback(function(){
    var caserequest = new XMLHttpRequest();
    caserequest.open('GET','analyticScripts/jsontest.php',true);
    caserequest.onload = function(){
    casedata =JSON.parse(this.response);
    // console.log(this.response);
    // console.log(casedata);
    drawBarCharts(casedata);
    console.log("Drawing bar and line charts");
    drawLineCharts(casedata);
    

}
caserequest.send();

});


//Drawing Material Bar Chart

google.charts.load('current', {'packages':['bar']});
google.charts.setOnLoadCallback(function(){

    var specialistrequest = new XMLHttpRequest();
    specialistrequest.open('GET','analyticScripts/specialistrequest.php',true);
    specialistrequest.onload = function(){
        specialistData = JSON.parse(this.response);
        // console.log("test");
        // console.log("SPECI",specialistData);
        // console.log("testing",getSpecialistCaseData(casedata,"2","test"));
        // getSpecialistCases(casedata,'2');
        // console.log("chartArray",getChartArraySpecialist(casedata,specialistData));
        //  drawMaterialChart(specialistData,casedata);
    }
    
specialistrequest.send();
});

var specialistrequest = new XMLHttpRequest();
    specialistrequest.open('GET','analyticScripts/specialistrequest.php',true);
    specialistrequest.onload = function(){
        var specialistData = JSON.parse(this.response);
        console.log("SPECI",specialistData);
    }
    
//draws Pie Charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(function(){

var callrequest2 = new XMLHttpRequest();
callrequest2.open('GET','analyticScripts/callsjson.php',true);
callrequest2.onload = function(){
var calldata2 =JSON.parse(this.response);
drawPieChart(calldata2);
}
callrequest2.send();
    
});





function getCases(casedata,startDate,endDate){
    len=casedata.length;
    startDateInt = Date.parse(startDate);
    endDateInt = Date.parse(endDate);
    cases=[];
    for(var i=0;i<len;i++){
        caseDate = Date.parse(casedata[i].TimeOpened);
        if((caseDate<endDateInt)&& (caseDate>startDateInt)){
            cases.push(casedata[i]);
        }
        
    }
    return cases;

}

function getCalls(calldata,startDate,endDate){
    len = calldata.length;
    startDateInt = Date.parse(startDate);
    endDateInt = Date.parse(endDate);
    calls=[];
    for(var i=0;i<len;i++){
        callDate = Date.parse(calldata[i].CallStartTime);
        if((callDate<endDateInt)&& (callDate>startDateInt)){
            calls.push(calldata[i]);
        }
        
    }
    return calls;

}

document.getElementById("chartButton").addEventListener("click",getDatedCaseData);


function getDatedCaseData(){
    var startdate = start.value;
    var enddate = end.value;
    console.log("PLEASE WORK");
    console.log(getCases(casedata,startdate,enddate));
    console.log(getCalls(calldata,startdate,enddate));
    
    datedCases = getCases(casedata,startdate,enddate);
    datedCalls = getCalls(calldata,startdate,enddate);
    //Pie Chart Drawing 
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawPieChart(datedCalls));

    //Bar Chart Drawing
    google.charts.load('current', {packages: ['corechart', 'bar']});
    google.charts.setOnLoadCallback(drawBarCharts(datedCases));


    //Line Chart Drawing
    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(drawLineCharts(datedCases));

    //Draw Material Chart
    google.charts.load('current', {'packages':['bar']});
    google.charts.setOnLoadCallback(drawMaterialChart(specialistData,datedCases));





}




function getDatedCaseData2(){
    var days= document.querySelector('input[name="specifiedTime"]:checked').value;
    var today = new Date().toISOString().slice(0,10);
    var d30 = new Date();
    d30.setDate(d30.getDate()-days);
    startDateRadio = d30.toISOString().slice(0,10);
        // console.log(startDate);
        endDate = today;
    
    console.log(today,startDateRadio);

    datedCases = getCases(casedata,startDateRadio,endDate);
    datedCalls = getCalls(calldata,startDateRadio,endDate);

    console.log("dated",datedCases);
    console.log("dated",datedCalls);


     //Pie Chart Drawing 
     google.charts.load('current', {'packages':['corechart']});
     google.charts.setOnLoadCallback(drawPieChart(datedCalls));
 
     //Bar Chart Drawing
     google.charts.load('current', {packages: ['corechart', 'bar']});
     google.charts.setOnLoadCallback(drawBarCharts(datedCases));
 
 
     //Line Chart Drawing
     google.charts.load('current', {packages: ['corechart', 'line']});
     google.charts.setOnLoadCallback(drawLineCharts(datedCases));
 
     //Draw Material Chart
     google.charts.load('current', {'packages':['bar']});
     google.charts.setOnLoadCallback(drawMaterialChart(specialistData,datedCases));

}



/**
 * Will count values of a given key value pair in Array.
 *  EG caseArr, "Software", "Firezilla" returns 4 
 * @param {*} caseArr 
 * @param {*} key 
 * @param {*} value 
 * @returns 
 */
function countKey(caseArr,key,value){
    // console.log("Count Key function called");
    sum=0;
    for(i=0;i<caseArr.length;i++){
        if(caseArr[i][key] == value){
            sum++;
        }
    }
    return sum;
}



/**
 * Returns array [[Value,countVal]]
 * Counts instances of that value from a given key in JSON
 * @param {*} caseArr 
 * @param {*} key 
 * @returns 
 */
function getDataArray(caseArr,key){
    uniqueValArray = getKeyValues(caseArr,key,1);
    dataArray=[];
    len = uniqueValArray.length;
    for(j=0;j<len;j++){
        v = uniqueValArray[j];
        w=countKey(caseArr,key,uniqueValArray[j]);
        dataArray.push([v,w]);
    }

    return dataArray;

}

/**
 * Returns an array of keys
 * EG ["CallID","OperatorEmpID"]
 * @param {*} data 
 * @returns 
 */
function getKeyArray(data){
    keyArray=Object.keys(data[0]);
    // console.log(keyArray);
    return keyArray;
}



/**
 * Returns values of a given key.
 * if unique is set to 1 it removes duplicates.
 * @param {*} caseArr 
 * @param {*} key 
 * @param {*} unique 
 * @returns 
 */
function getKeyValues(caseArr,key,unique=0){
    console.log("being run");
    keyArray=[];
    for(i=0;i<caseArr.length;i++){
        keyArray.push(caseArr[i][key]);
    }
    if(unique ==0){
        return keyArray;
    }else{
        uniqueKeyArray = [...new Set(keyArray)];
        return uniqueKeyArray;
    }
        
    
}






/**
 * Draws Pie Charts using google charts library.
 * @param {*} caseArr 
 */
function drawPieChart(caseArr) {
    
    deptArray = getDataArray(caseArr,"Dept");
    deptArray.unshift(["Department","Number of Cases"]);
    console.log(deptArray);
    var data = google.visualization.arrayToDataTable(deptArray);

    var options = {
    title: "Department's Case Numbers",
    is3D: true,
    };
    
    var chart = new google.visualization.PieChart(document.getElementById('departmentPieChart'));
    
    chart.draw(data, options);



}

/**
 * Draws Bar Charts using google charts library.
 * @param {*} caseArr 
 */
function drawBarCharts(caseArr) {

    
    swDataArray = getDataArray(caseArr,"Software");
    oSDataArray = getDataArray(caseArr,"OperatingSystem");
    swDataArray.unshift(["Software","Number of Cases"]);
    oSDataArray.unshift(["Operating System","Number of Cases"]);

    // console.log("ss",swDataArray);

    var swData = google.visualization.arrayToDataTable(swDataArray);
    var oSData = google.visualization.arrayToDataTable(oSDataArray);
    
    var swOptions = {
    title: 'Number of Cases Involving a Piece of Software',
    chartArea: {width: '50%'},
    hAxis: {
        title: 'Number of Cases',
        minValue: 0
    },
    vAxis: {
        title: 'Software'
    }
        };
    var hwOptions = {
        title: 'Number of Cases on an Operating System',
    chartArea: {width: '50%'},
    hAxis: {
        title: 'Number of Cases',
        minValue: 0
    },
    vAxis: {
        title: 'Operating System'
    }
        };
        var chart = new google.visualization.BarChart(document.getElementById('softwareBarChart'));
    
        chart.draw(swData, swOptions);
        var chart2 =  new google.visualization.BarChart(document.getElementById('hardwareBarChart'));
        chart2.draw(oSData,hwOptions);


}


/**
 * Gets Cases with a given case Type. 
 * eg hardware or software
 * 
 * @param {*} caseArr 
 * @param {*} caseType 
 * @returns 
 */
function getCaseType(caseArr,caseType){
    len =caseArr.length;
  
    var returnedArr =[];
    for(i=0;i<len;i++){
        // console.log("case type loop",i);
        if (caseArr[i].Problem == caseType){
            returnedArr.push(caseArr[i]);
        }
    }

     sortedreturnedArr = returnedArr.sort((a,b)=>new Date(a.Date_of_Call) - new Date(b.Date_of_Call));
    //  console.log(sortedreturnedArr);
    return sortedreturnedArr;

}


/**
 * Returns cases with a given specialist ID
 * @param {*} caseArr 
 * @param {*} specialist specialist empID
 * @returns 
 */
function getSpecialistCases(casedata,specialist){
    var returnedArr =[];
    // console.log("getspecialistcases",casedata);
    for(var i=0; i<casedata.length; i++){
        if(casedata[i].EmpID==specialist){
            returnedArr.push(casedata[i]);
        }
    }
    // console.log("getspecialistcases returned",returnedArr);
    return returnedArr;
}



/**
 * Returns an array usable by google charts, given a caseArray and a given CaseType
 * @param {*} caseArr 
 * @param {*} caseType 
 * @returns 
 */
function getChartArray(caseArr, caseType){

    var dataArray=[];
    swCaseArray = getCaseType(caseArr,caseType);
    // console.log("sss",swCaseArray);
    len = swCaseArray.length;
    for(i=0;i<len;i++){
        d = new Date(swCaseArray[i].TimeOpened);
        dataArray.push([d,i+1]);
    }
    
    return dataArray; 
}

/**
 * Draws Line Charts using google charts library.
 * @param {*} caseArr 
 */
function drawLineCharts(caseArr) {
    
    rows = getChartArray(caseArr,"Software");
    var data1 = new google.visualization.DataTable();
    data1.addColumn('datetime', 'X');
    data1.addColumn('number', 'Cases');

    data1.addRows(rows);

    var options = {
      curveType: "function",
      hAxis: {
        title: 'Date'
      },
      vAxis: {
        title: 'Number of Software Cases'
      }
    };

    var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
    chart.draw(data1, options);

    rows2 = getChartArray(caseArr,"Hardware");
  //   console.log("rows2 - ",rows2);
    var data2 = new google.visualization.DataTable();
    data2.addColumn("datetime", "X");
    data2.addColumn("number", "Cases");

    var options2 ={
        curveType : "function",
        hAxis:{
            title: "Date"
        },
        vAxis:{
            title : "Number of Hardware Cases"
        }
        
    };

    data2.addRows(rows2);

    var chart2 = new google.visualization.LineChart(document.getElementById("chart_div2"));
    chart2.draw(data2,options2);



    rows3 = getChartArray(caseArr,"Network");
    // console.log("rows3",rows3);
    var data3 = new google.visualization.DataTable();
    data3.addColumn("datetime","X");
    data3.addColumn("number","Cases");

    var options3 ={
        curveType: "function",
        hAxis:{
            title: "Date"
        },
        vAxis:{
            title:"Number of Networking Cases"
        }
    };

    data3.addRows(rows3);
    var chart3 = new google.visualization.LineChart(document.getElementById("chart_div3"));
    chart3.draw(data3,options3);


    

}


/**
 * Should return array with [specialistname,H,S,N]
 * With H S N being number of hardware software and network cases they worked on. 
 * @param {*} casedata 
 * @param {*} specialist 
 */
function getSpecialistCaseData(casedata,specialist,name){
    // console.log("case data before specialstcasescalled",casedata);
    var spAllCaseArray=getSpecialistCases(casedata,specialist);
    len =spAllCaseArray.length;
    var h=0;
    var s=0;
    var n=0;
    for(var i=0; i<len; i++){
        if(spAllCaseArray[i].Problem ==="Hardware" && (spAllCaseArray[i].CaseStatus==="Closed" || spAllCaseArray[i].CaseStatus==="Resolved")){
            h=h+1;
        }else if (spAllCaseArray[i].Problem === "Software" && (spAllCaseArray[i].CaseStatus==="Closed" || spAllCaseArray[i].CaseStatus==="Resolved")){
            s=s+1;
        }else if (spAllCaseArray[i].Problem ==="Network" && (spAllCaseArray[i].CaseStatus==="Closed" || spAllCaseArray[i].CaseStatus==="Resolved")){
            n=n+1;
        }
    }
    var returnedArr=[name,h,s,n];
    return returnedArr;


}



//not implemented yet fully TODO
function getChartArraySpecialist(casedata,specialistData){
    console.log("getchart ran");
    var dataArray=[];
    for(var i=0; i< specialistData.length;i++){
        dataArray.push(getSpecialistCaseData(casedata,specialistData[i].EmpID,specialistData[i].Name));
    }
    // console.log("dataarr",dataArray);
    return dataArray;
}

function drawMaterialChart(specialistData,casedata){
    // console.log("case data in draw material chart",casedata);
    var data = new google.visualization.DataTable();
    data.addColumn("string","Specialist");
    data.addColumn("number","Hardware Cases");
    data.addColumn("number","Software Cases");
    data.addColumn("number","Network Cases");

    rows = getChartArraySpecialist(casedata,specialistData);
    data.addRows(rows);

    var options ={
        chart: {
            title: "Specialist Performance by Cases Solved"
        },
        bars: "horizontal"
    };

    var chart = new google.charts.Bar(document.getElementById("barchart_material"));
    chart.draw(data,options);



}

    