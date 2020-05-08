<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->setTitle("Contacts");
?><div class="block-title">
	<h1>Contacts</h1>
</div>
<div class="cat-info-block contacts-block" style="margin: 20px 0;">
	<div class="line" style="margin-bottom:20px;">
		 Fodyo.com
	</div>
	 <?/*<div class="line">
         Phone number: <a href="tel:+79045643344">+7 (495) 665 22 55</a>
    </div>*/?>
	<div class="line">
		 E-mail: <a href="mailto:mail@fodyo.com">mail@fodyo.com</a>
	</div>
</div>
<div class="sidebar-right not-sidebar" style="max-width: 500px;width: 100%;">
	<div class="head">
 <span class="micro-title">Contact Us</span>
	</div>
	<div class="form-cons">
 <input type="text" name="name" placeholder="Write your name"> <input type="text" name="phone" placeholder="Write your phone"> <textarea placeholder="Write your message"></textarea>
		<div class="flex-captcha">
 			<img src="/bitrix/templates/23/ajax/captcha.php" class="captchaImg" title="Reload"> <input type="text" name="captcha" placeholder="Text from image">
		</div>
		<div class="form-cons-submit form-submit" id="contact-form-submit">
			 Submit
		</div>
		<div class="checkboxAgrementBlockInContact">
                    <input type="checkbox" id="idCheckboxInContact" onchange="funcOnchangeCheckboxInContact()">
                    <div class="agreement black">
                        I have read the 
                        <a href="/policy/" class="agreement-link" target="_blank">Privacy policy</a>
                    </div>
                </div>
                <div class="checkboxPolicyBlockInContact">
                    <input type="checkbox" id="idCheckboxPolicyInContact" onchange="funcOnchangeCheckboxInContact()">
                    <div class="agreement black">
                        I have read and accept the 
                        <a href="/policy/" class="agreement-link" target="_blank">Terms of use</a>
                    </div>
                </div>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>