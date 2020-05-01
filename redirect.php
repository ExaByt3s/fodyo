<?php
$user_ip = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_CONNECTING_IP"]:$_SERVER['REMOTE_ADDR']);
$user_country = (isset($_SERVER["HTTP_CF_CONNECTING_IP"])?$_SERVER["HTTP_CF_IPCOUNTRY"]:$_SERVER['REMOTE_ADDR']);

$ip = $_SERVER['HTTP_CLIENT_IP'];

echo "HTTP_CF_CONNECTING_IP: ".$_SERVER["HTTP_CF_CONNECTING_IP"].";<BR>";
echo "HTTP_CLIENT_IP: ".$_SERVER['HTTP_CLIENT_IP'].";<BR>";
echo "REMOTE_ADDR: ".$_SERVER['REMOTE_ADDR'].";<BR>";
echo "HTTP_CF_IPCOUNTRY: ".$_SERVER["HTTP_CF_IPCOUNTRY"].";<BR>";
$ipremote = $_SERVER['REMOTE_ADDR'];
if ($user_country == 'RU') //код страны
{
        //header("HTTP/1.1 301 Moved Permanently");
        //header('Location: https://fodyo.com/ru-ru/'); // сайт для страны.
}
else
{
        //header("HTTP/1.1 301 Moved Permanently");
        //header('Location: https://fodyo.com/en-us/'); // сайт, на который перейдет посетитель, если для его страны нет отдельного сайта.
}
?>