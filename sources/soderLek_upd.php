<?php
require_once 'db_connect.php';
$doc_id = $_GET['doc_id'];
$temaDiscpl = $_GET['temaDiscpl'];
$hourLekForTems  = $_GET['hourLekForTems'];
$semestr = $_GET['semestrForTems'];

$query = "select * from discpl2semestr where ctitle = $doc_id and semestr = $semestr";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row = pg_fetch_array($result);
$discpl2semestr = $row['id'];

$query1 = "insert into discpl2lek (cdiscpl2semestr, tema, hour) values ($discpl2semestr, '$temaDiscpl', $hourLekForTems)";
$result = pg_query($query1) or die('Ошибка запроса: ' . pg_last_error());
$referer = $_SERVER['HTTP_REFERER'];
$address = "Location: " . $referer;

header($address);
exit();
?>
