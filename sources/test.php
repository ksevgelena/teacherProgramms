<?php
require_once 'bootstrap.php';
require_once 'db_connect.php';

$query = "select * from title2zadachi
          where ctitle = 10";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$zadachi = $row['zadachi'];

echo "hello \n\r";
echo $zadachi;
echo stristr($zadachi, "/n");
?>