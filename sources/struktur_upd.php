<?php
require_once 'db_connect.php';
require_once 'myFunction.php';
var_dump($_GET);
$doc_id = $_GET['doc_id'];
//удалим все данные из discpl2semestr, discpl2hour по выбранному предмету
$query = "delete from discpl2hour where cdiscpl2semestr in (select id from discpl2semestr where ctitle = $doc_id); delete from discpl2semestr where ctitle = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());

//заполним таблицы новыми данными
$query = "select * from cattitle where id = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$first_semestr = $row['first_semestr'];
$count_semestr = $row['count_semestr'];
for ($i = 1; $i<=$count_semestr; $i++){
    $semestr = $first_semestr-1 + $i;
    $kindAtt = $_GET['kindAtt_sem'.strval($i)];
    $kindAttKurs =  $_GET['kindAttKurs_sem'.strval($i)];
    //вносим данные о семестре в таблицу discpl2semestr
    $query1 = "insert into discpl2semestr (ctitle, semestr, cformcontr, ckurs) values ($doc_id, $semestr,$kindAtt, $kindAttKurs) RETURNING id";
    $result1 = pg_query($query1) or die('Ошибка запроса: ' . pg_last_error());
    $row =  pg_fetch_array($result1);
    $cdiscpl2semestr = $row['id'];
    echo $cdiscpl2semestr;
    //заполнение переменных часасми
    $hourLek   = setNull($_GET['hourLek_sem'.strval($i)]);
    $hourLab   = setNull($_GET['hourLab_sem'.strval($i)]);
    $hourPrakt = setNull($_GET['hourPrakt_sem'.strval($i)]);
    $hourSam   = setNull($_GET['hourSam_sem'.strval($i)]);
    $hourAtt   = setNull($_GET['hourAtt_sem'.strval($i)]);

    //вносим данные о часах в таблицу discpl2hour
    $query2 = "insert into discpl2hour (cdiscpl2semestr, ckindlesson,hour) values ($cdiscpl2semestr,1,$hourLek);
               insert into discpl2hour (cdiscpl2semestr, ckindlesson,hour) values ($cdiscpl2semestr,2,$hourLab);
               insert into discpl2hour (cdiscpl2semestr, ckindlesson,hour) values ($cdiscpl2semestr,3,$hourPrakt);
               insert into discpl2hour (cdiscpl2semestr, ckindlesson,hour) values ($cdiscpl2semestr,4,$hourSam);
               insert into discpl2hour (cdiscpl2semestr, ckindlesson,hour) values ($cdiscpl2semestr,5,$hourAtt);";
    $result2 = pg_query($query2) or die('Ошибка запроса: ' . pg_last_error());
}


//




?>