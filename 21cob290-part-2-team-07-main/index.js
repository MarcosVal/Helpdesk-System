var employees = [
    {
        username: "Alice",
        password: "#operator123",
        code: "1234"},
	{
		username: "Bert",
		password: "hardWare5",
        code: "5555"},
	{
		username: "Clara",
		password: "SOFTware404",
        code: "6644"}
]

function checkInputs() {
	var username = document.getElementById('username').value
	var password = document.getElementById('password').value
    var code = document.getElementById('2FAcode').value
	
    if(username==='' || password==='' || code===''){
        return
	}
	
	var found = false
	for(var i=0; i<employees.length; i++) {
		if(username == employees[i].username && password == employees[i].password
            && code == employees[i].code) {
			found = true
			break
		}
	}
	
	if(found==false){
		alert("incorrect data")
		return
	}
	
	window.location.href = "http://team007.sci-project.lboro.ac.uk/cases.html";
	//switchWin();
	// window.location.href = "cases.html";
	// location.href = "http://team007.sci-project.lboro.ac.uk/cases.html";
	// location.assign("http://team007.sci-project.lboro.ac.uk/cases.html");
	// location.replace("/cases.html");
	// location.href = '/js/cases.html';
	// //alert("correct data");
	// window.location.href = "cases.html";
	// window.location.replace("/cases.html");
}

    


// function switchWin(){
// 	window.location.href = "http://team007.sci-project.lboro.ac.uk/cases.html";
// 	return
// }


//code for calls.html

// var personnel = [
//     {
//         "Employee_ID" : "0003",
//         "Caller_ID" : "1458756",
//         "Name": "Matthew Patel",
//         "Job_Title": "Market Researcher",
//         "Department": "Marketing",
//         "Telephone_Number": "07745668943",
//         "Cases_Unresolved": [1,6,11],
//         "Cases_Resolved": [15]
//     },
//     {
//         "Employee_ID" : "0004",
//         "Caller_ID" : "2784365",
//         "Name": "John Smith",
//         "Job_Title": "Recruiter",
//         "Department": "Human Resources",
//         "Telephone_Number": "07747812453",
//         "Cases_Unresolved": [2],
//         "Cases_Resolved": [4,8,12]
//     },
//     {
//         "Employee_ID" : "0005",
//         "Caller_ID" : "1486752",
//         "Name": "Josh Sanderson",
//         "Job_Title": "Chief Diversity Officer",
//         "Department": "Human Resources",
//         "Telephone_Number": "07748675120",
//         "Cases_Unresolved": [3,10],
//         "Cases_Resolved": [7]
//     },
//     {
//         "Employee_ID" : "0006",
//         "Caller_ID" : "4739815",
//         "Name": "David Schmiff",
//         "Job_Title": "Customer Care Operator",
//         "Department": "Customer Service",
//         "Telephone_Number": "07747698430",
//         "Cases_Unresolved": [],
//         "Cases_Resolved": [5,13]
//     },
//     {
//         "Employee_ID" : "0007",
//         "Caller_ID" : "14589623",
//         "Name": "Anna Schmiff",
//         "Job_Title": "Account Representative",
//         "Department": "Customer Service",
//         "Telephone_Number": "07747698320",
//         "Cases_Unresolved": [],
//         "Cases_Resolved": [9,14]
//     }
// ]

// function personnelData(){
// 	for(var i=0; i<personnel.length; i++) {
// 		'<tr><td class="col">'+personnel[i].Caller_ID+'</td>';
// 		'<td class="col">'+personnel[i].Name+'</td>';
// 		'<td class="col">'+personnel[i].Job_Title+'</td>';
// 		'<td class="col">'+personnel[i].Department+'</td>';
// 		'<td class="col">'+personnel[i].Telephone_Number+'</td>';
// 		`<td class="col">${personnel[i].Cases_Unresolved}</td></tr>`;
// 	}
// }
    
    

    
