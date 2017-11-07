<?php
require_once 'db_connect.php';
$doc_id = $_GET['doc_id'];
$cel =    $_GET['cel'];
$zad =    $_GET['zad'];

$query = "delete from title2zadachi where ctitle = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());

$query1 = "insert into title2zadachi (ctitle, celi, zadachi) values ($doc_id, '$cel', '$zad')";
$result = pg_query($query1) or die('Ошибка запроса: ' . pg_last_error());
$referer = $_SERVER['HTTP_REFERER'];
$address = "Location: " . $referer;

header($address);
exit();
?>