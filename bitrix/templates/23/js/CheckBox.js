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
$(document).ready(function(){
		document.getElementById("hrefButtonPopupForm").style["background"] = "#585858";
		document.getElementById("hrefButtonPopupForm").style["pointer-events"] = "none";
});