<?php
require_once 'db_connect.php';
$doc_id = $_GET['doc_id'];
$do = $_GET['do'];
$posle  = $_GET['posle'];

$query = "delete from title2placeInStructur where ctitle = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());

$query1 = "insert into title2placeInStructur (ctitle, doo, posle) values ($doc_id, '$do','$posle')";
$result = pg_query($query1) or die('Ошибка запроса: ' . pg_last_error());
$referer = $_SERVER['HTTP_REFERER'];
$address = "Location: " . $referer;

header($address);
exit();
?>