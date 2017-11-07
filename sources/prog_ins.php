<?php
require_once 'db_connect.php';

$discpl = $_GET['discpl'];

$query = "Insert into cattitle (cdiscpl,creater) values ('$discpl',1) RETURNING id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$doc_id = $row['id'];
$address = "Location: title.php?doc_id_=$doc_id";
header($address);
exit();
?>
