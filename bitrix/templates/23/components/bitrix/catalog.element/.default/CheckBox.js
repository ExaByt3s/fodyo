function funcOnchangeCheckboxInSidebar(){

	console.log("click");
	var chboxAgriment=document.getElementById("idCheckboxInSidebar");
	var chboxPolicy=document.getElementById("idCheckboxPolicyInSidebar");

	if (chboxAgriment.checked && chboxPolicy.checked) {
		//document.getElementById("hrefButtonPopupForm").disabled = false;
		document.getElementById("hrefButtonSidebarForm").style["background"] = "linear-gradient(0deg, rgba(219, 68, 37, 1) 0%, rgba(227, 97, 53, 1) 57%)";
		document.getElementById("hrefButtonSidebarForm").style["pointer-events"] = "auto";
	}
	else {
		//document.getElementById("hrefButtonPopupForm").disabled = true;
		document.getElementById("hrefButtonSidebarForm").style["background"] = "#585858";
		document.getElementById("hrefButtonSidebarForm").style["pointer-events"] = "none";
		
		/*var hover = document.createTextNode(".form-submit:hover{background: linear-gradient(0deg, rgba(227, 97, 53, 1) 0%, rgba(219, 68, 37, 1) 57%)}");

		var style = document.createElement('style');
		style.type = 'text/css';
		style.appendChild(hover);
    	document.getElementById("hrefButtonPopupForm").appendChild(style);*/


	}
}

$(document).ready(function(){
		document.getElementById("hrefButtonSidebarForm").style["background"] = "#585858";
		document.getElementById("hrefButtonSidebarForm").style["pointer-events"] = "none";
});