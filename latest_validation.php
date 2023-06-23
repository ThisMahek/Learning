<?php
//call oninput="validateAdhaar('aadhar_card_vendor','msgadhar','btn')"
//for email validation
 function validate_email(field, msg, btn) {
        var emailVal = $("#" + field).val();
        var message= document.getElementById(msg);
        var regad = /[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/;
        if (regad.test(emailVal) == true || emailVal=="" ) {
            message.innerHTML = ("");
            message.style.color = "";
            document.getElementById(btn).disabled = false;
        }
        else {
            message.innerHTML = "Invalid email id";
            message.style.color = "red";
            document.getElementById(btn).disabled = true;

        }
    }
	// calling method oninput="matchPassword('password','confirm_password','password_error','password_id')"
	//for password and confirm password
	function matchPassword(pwd, cpwd, msg, btn) {

        var password = $("#" + pwd).val();
        var confirm_password = $("#" + cpwd).val();
        var message = document.getElementById(msg);
        if (password != confirm_password) {
            message.innerHTML = "Password and confirm password did not match: Please try again....";
            message.style.color = "red";
            document.getElementById(btn).disabled = true;

        }
        else {
            message.innerHTML = ("");
            message.style.color = "";
            document.getElementById(btn).disabled = false;
            return true;
        }

    }
?>