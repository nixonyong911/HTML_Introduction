/*
Author: Nixon Yong
Target: quiz.html
Purpose: This is for assignment 2
Created: 20 sep 2016
Last updated: 20 sep 2016
Credits: assignmnt 2
*/

"use strict";

function init(){
	var quiz = document.getElementById("quizForm");
	quiz.onsubmit = validate; //Call validate function when the form is submitted.
	prefill_answer(); //fill up the page if user has already filled up before.
	//to check whether has user attempt before.
}
	
//method to validate the quiz and calculate user's score.
function validate(){
	var result = true;
	var errorMessage = "";
	var totalMark = 0;
	var q1 = getAnswer("q1");
	var q2 = getAnswer("q2");
	var q3a = document.getElementById("q3a").checked;
	var q3b = document.getElementById("q3b").checked;
	var q3c = document.getElementById("q3c").checked;
	var q3d = document.getElementById("q3d").checked;
	var q4 = document.getElementById("q4").value;
	var q5 = document.getElementById("q5").value;
	
	if(isNaN(q5)){
		result = false;
		alert('Question 5, please enter numerical value');
	}
	
	//if(!(q3a || q3b || q3c || q3d)){
	//	errorMessage += "Please fill up question3\n";
	//	result = false;
	//}
	
	if(errorMessage !== ""){
		alert(errorMessage);
	}
	
	if(getAnswer("q1") === "q1a"){
		totalMark += 2;
	}
	
	if(getAnswer("q2") === "q2b"){
		totalMark += 2;
	}
	
	if(q3b === true && q3d === true && q3a === false && q3c === false){
		totalMark += 2;
	}
	
	if(document.getElementById("q4").value === "2011"){
		totalMark += 2;
	}
	
	if(q5 =="5"){
		totalMark += 2;
	}
	
	//if(totalMark === 0 && result !== false){
	//	alert("You scored 0, please try again.");
	//	result = false;
	//}
	
	if(result){
		result = storeAnswer(q1, q2, q3a, q3b, q3c, q3d, q4, q5);
	}
	
	return result;
}

//to get what input(answer) has the user selected.
function getAnswer(question){
	var answer = "";
	var answerArray = document.getElementById(question).getElementsByTagName("input");
	for(var i = 0; i<answerArray.length; i++){
		if(answerArray[i].checked)
			answer = answerArray[i].value;
	}
	return answer;
}

//store the answer so when user reload the page, the fill are pre-filled.
function storeAnswer(q1, q2, q3a, q3b, q3c, q3d, q4, q5){
	var studentID = document.getElementById("studentID").value;
	
	if(localStorage.getItem(studentID.toString()) == undefined)
		localStorage.setItem(studentID.toString(), "0");
	
	var attempt = localStorage.getItem(studentID.toString());
	var q3 = "";
	//validate studentID for attempt
	if (attempt != "3"){
		//attempt ++;
		sessionStorage.attempt = attempt;
		localStorage.setItem(studentID.toString(), attempt.toString());
	}
	else {
		alert("You have reached maximum attempt.");
		return false;
	}
	if(q3a) q3 += "q3a";
	if(q3b) q3 += " q3b";
	if(q3c) q3 += " q3c";
	if(q3d) q3 += " q3d";
	sessionStorage.firstName = document.getElementById("firstName").value;
	sessionStorage.lastName = document.getElementById("lastName").value;
	sessionStorage.studentID = document.getElementById("studentID").value;
	sessionStorage.DOB = document.getElementById("DOB").value;
	sessionStorage.sex = document.getElementById("sex").value;
	sessionStorage.q1 = q1;
	sessionStorage.q2 = q2;
	sessionStorage.q3 = q3;
	sessionStorage.q4 = q4;
	sessionStorage.q5 = q5;
	return true;
}

//check for the sessionStore to determine is there is prefilled sessionStorage.
//if exist then fill up.
function prefill_answer(){	
	
	if(sessionStorage.firstName !== undefined)
		document.getElementById("firstName").value = sessionStorage.firstName;
	
	if(sessionStorage.lastName !== undefined)
		document.getElementById("lastName").value = sessionStorage.lastName;
	
	if(sessionStorage.studentID !== undefined)
		document.getElementById("studentID").value = sessionStorage.studentID;
	
	if(sessionStorage.DOB !== undefined)
		document.getElementById("DOB").value = sessionStorage.DOB;
		
	if(sessionStorage.sex !== undefined)
		document.getElementById("sex").value = sessionStorage.sex;
	
	switch(sessionStorage.q1){
			case "q1a":
				document.getElementById("q1a").checked = true;
				break;
			case "q1b":
				document.getElementById("q1b").checked = true;
				break;
			case "a1c":
				document.getElementById("a1c").checked = true;
				break;
			case "a1d":
				document.getElementById("a1d").checked = true;
				break;
	}
	
	switch(sessionStorage.q2){
			case "q2a":
				document.getElementById("q2a").checked = true;
				break;
			case "q2b":
				document.getElementById("q2b").checked = true;
				break;
			case "a2c":
				document.getElementById("a2c").checked = true;
				break;
			case "a2d":
				document.getElementById("a2d").checked = true;
				break;
	}
	
	if(sessionStorage.q3 !== undefined){
		var q3 = sessionStorage.q3.split(" ");
		for(var i = 1; i < q3.length; i++){
			document.getElementById(q3[i]).checked = true;
		}
	}
	
	if(sessionStorage.q4 !== undefined)
		document.getElementById("q4").value = sessionStorage.q4;
	
	if(sessionStorage.q5 !== undefined)
		document.getElementById("q5").value = sessionStorage.q5;
}
$(init);