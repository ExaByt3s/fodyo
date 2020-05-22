function funcOnchangeCheckboxInFooter(){
	var chboxAgriment=document.getElementById("idCheckboxInFooter");
	var chboxPolicy=document.getElementById("idCheckboxPolicyInFooter");
	if (chboxAgriment.checked && chboxPolicy.checked) {
		document.getElementsByClassName("confirm-callback")[0].disabled = false;
	}
	else {
		document.getElementsByClassName("confirm-callback")[0].disabled = true;
	}
}
function funcOnchangeCheckboxInPopup(){
	var chboxAgriment=document.getElementById("idCheckboxInPopup");
	var chboxPolicy=document.getElementById("idCheckboxPolicyInPopup");
	if (chboxAgriment.checked && chboxPolicy.checked) {
		document.getElementById("hrefButtonPopupForm").style["background"] = "linear-gradient(0deg, rgba(219, 68, 37, 1) 0%, rgba(227, 97, 53, 1) 57%)";
		document.getElementById("hrefButtonPopupForm").style["pointer-events"] = "auto";
	}
	else {
		document.getElementById("hrefButtonPopupForm").style["background"] = "#585858";
		document.getElementById("hrefButtonPopupForm").style["pointer-events"] = "none";
	}
}

function funcOnchangeCheckboxInContact(){
	var chboxAgriment=document.getElementById("idCheckboxInContact");
	var chboxPolicy=document.getElementById("idCheckboxPolicyInContact");
	if (chboxAgriment.checked && chboxPolicy.checked) {
		document.getElementById("contact-form-submit").style["background"] = "linear-gradient(0deg, rgba(219, 68, 37, 1) 0%, rgba(227, 97, 53, 1) 57%)";
		document.getElementById("contact-form-submit").style["pointer-events"] = "auto";
	}
	else {
		document.getElementById("contact-form-submit").style["background"] = "#585858";
		document.getElementById("contact-form-submit").style["pointer-events"] = "none";
	} 
}

$(document).ready(function(){
	document.getElementById("contact-form-submit").style["background"] = "#585858";
	document.getElementById("contact-form-submit").style["pointer-events"] = "none";
});

$(document).ready(function(){
	document.getElementById("hrefButtonPopupForm").style["background"] = "#585858";
	document.getElementById("hrefButtonPopupForm").style["pointer-events"] = "none";
});


/*$(document).ready(function(){
	document.getElementById("sberbank").style["background"] = "#585858";
	document.getElementById("sberbank").style["pointer-events"] = "none";
	
	document.getElementById("alfa").style["background"] = "#585858";
	document.getElementById("alfa").style["pointer-events"] = "none";
	
	document.getElementById("absolutbank").style["background"] = "#585858";
	document.getElementById("absolutbank").style["pointer-events"] = "none";
	
	document.getElementById("vozrojdenie").style["background"] = "#585858";
	document.getElementById("vozrojdenie").style["pointer-events"] = "none";
	
	document.getElementById("vtb").style["background"] = "#585858";
	document.getElementById("vtb").style["pointer-events"] = "none";
	
	document.getElementById("dom").style["background"] = "#585858";
	document.getElementById("dom").style["pointer-events"] = "none";
	
	document.getElementById("raifaizen").style["background"] = "#585858";
	document.getElementById("raifaizen").style["pointer-events"] = "none";
	
	document.getElementById("otkritie").style["background"] = "#585858";
	document.getElementById("otkritie").style["pointer-events"] = "none";
	
	document.getElementById("svjaz").style["background"] = "#585858";
	document.getElementById("svjaz").style["pointer-events"] = "none";
	
	document.getElementById("surgut").style["background"] = "#585858";
	document.getElementById("surgut").style["pointer-events"] = "none";
	
	document.getElementById("sovkom").style["background"] = "#585858";
	document.getElementById("sovkom").style["pointer-events"] = "none";
	
	document.getElementById("rosbank").style["background"] = "#585858";
	document.getElementById("rosbank").style["pointer-events"] = "none";
});

$(document).ready(function(){
	document.getElementById("WF").style["background"] = "#585858";
	document.getElementById("WF").style["pointer-events"] = "none";
	
	document.getElementById("BoA").style["background"] = "#585858";
	document.getElementById("BoA").style["pointer-events"] = "none";
	
	document.getElementById("Chase").style["background"] = "#585858";
	document.getElementById("Chase").style["pointer-events"] = "none";
	
	document.getElementById("Citibank").style["background"] = "#585858";
	document.getElementById("Citibank").style["pointer-events"] = "none";
	
	document.getElementById("Blueleaf").style["background"] = "#585858";
	document.getElementById("Blueleaf").style["pointer-events"] = "none";
	
	document.getElementById("Eclick").style["background"] = "#585858";
	document.getElementById("Eclick").style["pointer-events"] = "none";
	
	document.getElementById("Fairway").style["background"] = "#585858";
	document.getElementById("Fairway").style["pointer-events"] = "none";
	
	document.getElementById("Federal").style["background"] = "#585858";
	document.getElementById("Federal").style["pointer-events"] = "none";
	
	document.getElementById("United").style["background"] = "#585858";
	document.getElementById("United").style["pointer-events"] = "none";
	
	document.getElementById("Guaranteed").style["background"] = "#585858";
	document.getElementById("Guaranteed").style["pointer-events"] = "none";
	
	document.getElementById("Homestar").style["background"] = "#585858";
	document.getElementById("Homestar").style["pointer-events"] = "none";
});

function funcOnchangeCheckboxInBank(str){
	var chboxAgriment=document.getElementById("idCheckbox_" + str);
	var chboxPolicy=document.getElementById("idCheckboxPolicy_" + str);
	if (chboxAgriment.checked && chboxPolicy.checked) {
		document.getElementById(str).style["background"] = "linear-gradient(0deg, rgba(219, 68, 37, 1) 0%, rgba(227, 97, 53, 1) 57%)";
		document.getElementById(str).style["pointer-events"] = "auto";
	}
	else {
		document.getElementById(str).style["background"] = "#585858";
		document.getElementById(str).style["pointer-events"] = "none";
	}
}*/