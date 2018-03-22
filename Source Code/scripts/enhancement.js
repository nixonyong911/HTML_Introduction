/*
Author: Nixon Yong
Target: quiz.html
Purpose: This is for assignment 2
Created: 20 sep 2016
Last updated: 20 sep 2016
Credits: assignmnt 2
*/

"use strict";

//call startTimer function.
function initTimer(){
	var time = document.getElementById("time");
	startTimer(60, time);
}

//timer function
function startTimer(duration, time){
	var timeLeft = parseInt(duration);
	var minutes = parseInt("0");
	var seconds = parseInt("0");
	//constantly updating the function.
	function displayTime(){
		//math.floor to round it down.
		minutes = Math.floor(timeLeft / 60);
		seconds = timeLeft % 60;
		//if time less than 10, then 0 + time. Else just time
		minutes = minutes < 10 ? "0" + minutes : minutes;
		seconds = seconds < 10 ? "0" + seconds : seconds;
		//update the time.
		time.textContent = minutes + ":" + seconds;
		timeLeft --; //- one second
		//call autosubmit function.
		if(timeLeft === 0)
			autoSubmit();
	}
	//recall itself so until time runs out.
	displayTime();
	setInterval(displayTime, 1000);
}

//automatic submit when timer has reached 0
function autoSubmit(){
	alert("time out");
	document.getElementById("submit").click();
}

window.onload = initTimer;
//window.addEventListener('load',initTimer, false);