<?php
require_once 'db_connect.php';
$doc_id = $_GET['doc_id'];
$znat = $_GET['znat'];
$umet  = $_GET['umet'];
$vladet  = $_GET['vladet'];

$query = "delete from title2resultosvoen where ctitle = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());

$query1 = "insert into title2resultosvoen (ctitle, znat, umet, vladet) values ($doc_id, '$znat','$umet', '$vladet')";
$result = pg_query($query1) or die('Ошибка запроса: ' . pg_last_error());
$referer = $_SERVER['HTTP_REFERER'];
$address = "Location: " . $referer;

header($address);
exit();
?>