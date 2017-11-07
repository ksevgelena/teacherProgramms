<?php
require_once 'db_connect.php';
var_dump($_GET);

$doc_id = $_GET['doc_id'];
$comp = $_GET['int_kompetent'];

  $query = "delete from title2kompetent where ctitle = $doc_id";
    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
    $N = count($comp);
    for($i=0; $i < $N; $i++)
    {
        $query = "insert into title2kompetent (ctitle, ckompetent) values ($doc_id, $comp[$i])";
        $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
    }

$referer = $_SERVER['HTTP_REFERER'];
$address = "Location: " . $referer;

header($address);
exit();




/*
$cfac = $_GET['cfac'];
$ckaf = $_GET['ckaf'];
$discpl = $_GET['discpl'];

$query = "Update cattitle set cdiscpl = '$discpl', cfac = $cfac, ckaf = $ckaf, creater = 1 where id = $doc_id";
echo $query;
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$address = "Location: kompetentform.php";
header($address);
exit();*/
?>
