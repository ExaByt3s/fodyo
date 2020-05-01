<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

header("HTTP/1.0 404 Not Found");
CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");
define("HIDE_SIDEBAR", true);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Page not found");
$APPLICATION->SetPageProperty('title', "Page not found");
?>

    <div class="bx-404-container">
		<div class="bx-404-block"><img src="/images/404.png" alt=""></div>
        <div class="bx-404-text-block">Page not found</div>
		<div class="">Go back to <a href="/">main page</a></div>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>