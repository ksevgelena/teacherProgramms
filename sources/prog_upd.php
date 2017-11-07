<?php
require_once 'db_connect.php';

print "<br> CET";
var_dump($_GET);


$doc_id        = $_GET['doc_id'];
$cfac          = $_GET['cfac'];
$ckaf          = $_GET['ckaf'];
$discpl        = $_GET['discpl'];
$count_semestr = $_GET['count_semestr'];
$first_semestr = $_GET['first_semestr'];

//заполнение таблицы cattitle (update)
$query = "Update cattitle set cdiscpl = '$discpl', cfac = $cfac, ckaf = $ckaf, creater = 1, count_semestr = $count_semestr, first_semestr = $first_semestr where id = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
//заполнение таблицы discpl2semestr (insert)


$referer = $_SERVER['HTTP_REFERER'];
$address = "Location: " . $referer;

header($address);
exit();
?>

