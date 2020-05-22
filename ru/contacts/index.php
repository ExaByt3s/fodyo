<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->setTitle("Контакты");
?><div class="block-title">
	<h1>Контакты</h1>
</div>
<b>Нью-Йорк, США</b><br>
 <br>
 100 Church Street, &nbsp;<br>
 New York,&nbsp;NY 10007&nbsp;<br>
 <br>
 <b>Москва, Россия</b><br>
 <br>
 Москва, 107392,<br>
ул. Халтуринская 17,<br>
Номер телефона:&nbsp;<a href="tel:+74956652255">+7 (495) 665 22 55</a><br>
<div class="cat-info-block contacts-block" style="margin: 20px 0;">
	<div class="line" style="margin-bottom:20px;">
		 Fodyo.com
	</div>
	<div class="line">
		 Эл. Почта: <a href="mailto:mail@fodyo.com">mail@fodyo.com</a>
	</div>
</div>
<div class="sidebar-right not-sidebar" style="max-width: 500px;width: 100%;">
	<div class="head">
 <span class="micro-title">Бесплатная косультация</span>
	</div>
	<div class="form-cons">
 <input type="text" name="name" placeholder="Напишите ваше имя"> <input type="text" name="phone" placeholder="Напишите ваш телефон"> <textarea placeholder="Введите сообщение"></textarea>
		<div class="flex-captcha">
 <img src="/bitrix/templates/23/ajax/captcha.php" class="captchaImg" title="Перезагрузить"> <input type="text" name="captcha" placeholder="Текст с изображения">
		</div>
		<div class="form-cons-submit form-submit" id="contact-form-submit">
			 Оставить заявку
		</div>
		<div class="black">
			 Отправляя форму, вы подтверждаете своё <a href="/agreement/" class="agreement-link" target="_blank">согласие на обработку персональных данных</a>
		</div>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>