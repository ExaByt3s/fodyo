<?php
echo CAdminMessage::ShowNote('Модуль установлен');
?>
<form action="<?echo $APPLICATION->GetCurPage()?>">
	<input type="hidden" name="lang" value="<?=LANGUAGE_ID?>" />
	<input type="submit" name="" value="<?=GetMessage("CURRENCYUPDATER_MOD_BACK")?>" />
</form>
