<?php
require_once 'db_connect.php';

$doc_id = $_GET['doc_id'];
$query = "Update cattitle set delete = 't' where id = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$address = "Location: all_programms.php";
header($address);
exit();
?>
