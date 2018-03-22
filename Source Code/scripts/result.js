/*
Author: Nixon Yong
Target: result.html
Purpose: This is for assignment 2 quiz
Created: 8 sep 2016
Last updated: 8 sep 2016
Credits: assignment 2
*/

"use strict";

//confirmation
function validate(){					
	var result = true;								
	return result; 
}

//calculate the result.
function getResult(q1, q2, q3, q4, q5){
	var mark = 0;
	var q3 = q3.split(" ");
	if(q1 == "q1a")
		mark += 2;
	
	if(q2 == "q2b")
		mark += 2;
	
	if(q3[1] == "q3b" && q3[2] == "q3d")
		mark += 2;
	
	if(q4 == "2011")
		mark += 2;
	
	if(q5 == "5")
		mark +=2;
	
	return mark + "/10";
}

//check the number of attempt user has taken, if more than 3 then the redo button is disabled.
function checkAttempt(attempt){
	if(attempt >= 3){
		document.getElementById("redo").disabled = true;
		alert("You have reached the maximum number of attempt");
	}
}

//fetch the answer from sessionStorage
function getSelectedAnswer(){
		//confirmation text
		document.getElementById("confirm_name").textContent = sessionStorage.firstName + " " + sessionStorage.lastName;
		document.getElementById("confirm_studentID").textContent =sessionStorage.studentID;
		document.getElementById("confirm_DOB").textContent = sessionStorage.DOB;
		document.getElementById("confirm_sex").textContent = sessionStorage.sex;
		document.getElementById("confirm_attempt").textContent = sessionStorage.attempt;
		document.getElementById("confirm_result").textContent = getResult(sessionStorage.q1, sessionStorage.q2, sessionStorage.q3, sessionStorage.q4, sessionStorage.q5);		
		//hidden fields
		document.getElementById("firstName").value = sessionStorage.firstName;
		document.getElementById("lastName").value = sessionStorage.lastName;
		document.getElementById("DOB").value = sessionStorage.DOB;
		document.getElementById("sex").value = sessionStorage.sex;
		document.getElementById("q1").value = sessionStorage.q1;
		document.getElementById("q2").value = sessionStorage.q2;
		document.getElementById("q3").value = sessionStorage.q3;
		document.getElementById("q4").value = sessionStorage.q4;
		document.getElementById("q5").value = sessionStorage.q5;
}

function cancelBooking(){
	window.location = "quiz.html";
}

//initialize the page
function init () {
	var bookForm = document.getElementById("result");
	var redoButton = document.getElementById("redo");
	getSelectedAnswer();
	checkAttempt(document.getElementById("confirm_attempt").textContent);
	bookForm.onsubmit = validate; 
	redoButton.onclick = cancelBooking;
 }

window.onload = init;
