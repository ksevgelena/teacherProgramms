<?php
require_once 'db_connect.php';

function setNull($var){
    if ($var == "") return 'NULL';
        else
            return $var;
}
 //возвращает количество часов в зависимости от выбранной дисциплины, семестра и вида занятий (при формировании таблицы "Струкутра дисциплины" в Word)
function queryForHour($doc_id,$sem, $kind){
    $query = "select * from discpl2hour h
              left join discpl2semestr s on (h.cdiscpl2semestr = s.id)
              where semestr = $sem and ckindlesson = $kind and ctitle = $doc_id";

    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
    $row =  pg_fetch_array($result);
    $hour = $row['hour'];
    return $hour;
}
//возвращает сумму часов по выбранной дисциплине и виду занятий (при формировании таблицы "Струкутра дисциплины" в Word)
function queryForHourSum($doc_id, $kind){
    $query = "select sum(hour) from discpl2hour h
              left join discpl2semestr s on (h.cdiscpl2semestr = s.id)
              where ckindlesson = $kind and ctitle = $doc_id";

    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
    $row =  pg_fetch_array($result);
    $hourSum = $row['sum'];
    return $hourSum;
}
//возвращает форму контроля выбранной дисциплины и семестра (при формировании таблицы "Струкутра дисциплины" в Word)
function queryForFormcontr($doc_id, $sem){
    $query = "select f.name as e, ff.name as k, cformcontr, ckurs from discpl2semestr d2s
              left join cl\$formcontr f on (f.id = d2s.cformcontr)
              left join cl\$formcontr ff on (ff.id = d2s.ckurs)
              where semestr = $sem and ctitle = $doc_id";

    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
    $row =  pg_fetch_array($result);
//сохраняем форму контроля (кроме курсовых)
    if ($row['cformcontr']!=6) {
       $ekz = $row['e'];
    }
    else {
        $ekz = '';
    }
//сохраняем курсовик
    if ($row['ckurs']!=6) {
        $kurs = $row['k'];
    }
    else {
        $kurs = '';
    }
//определяем запятую
    if ($ekz == '' or $kurs == '') {
        $z = '';
    }
    else {
        $z = ', ';
    }
    $res = $ekz.$z.$kurs;
    return $res;
}
//возвращает ВСЕ формы контроля выбранной дисциплины по ВСЕМ семестрам (при формировании таблицы "Струкутра дисциплины" в Word)
function queryForFormcontrAll($doc_id){
    $query = "select distinct f.name from discpl2semestr d2s
              left join cl\$formcontr f on (f.id = d2s.cformcontr)
              where cformcontr<>6 and ctitle = $doc_id";
    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
    $res1 = '';
    $res2 = '';
    $res  = '';
    while ($row =  pg_fetch_array($result)){
        $textProm = $row['name'];
        if ($textProm == '' or $res1 == ''){$z = '';}
        else {$z = ', ';};
        $res1 = $res1.$z.$textProm;
    };
    $query = "select distinct f.name from discpl2semestr d2s
              left join cl\$formcontr f on (f.id = d2s.ckurs)
              where ckurs<>6 and ctitle = $doc_id";
    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
    while ($row =  pg_fetch_array($result)){
        $textProm = $row['name'];
        if ($textProm == '' or $res2 == ''){$z = '';}
        else {$z = ', ';};
        $res2 = $res2.$z.$textProm;
    };

    if ($res1 == '' or $res2 == '') {
        $z = '';
    }
    else {
        $z = ', ';
    }
    $res = $res1.$z.$res2;

    return $res;
}
//возвращает сумму аудиторных часов
//если $sem = 0, то считаем сумму всех аудиторных часов по ВСЕМ семестрам, иначе по конкретному семестру
function queryForAuditor($doc_id, $sem){
    if ($sem==0){
        $query = "select sum(hour) from discpl2hour  d2h
                  left join discpl2semestr d2s on (d2h.cdiscpl2semestr = d2s.id)
                  where ckindlesson in (1,2,3) and ctitle = $doc_id";
        $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
        $row =  pg_fetch_array($result);
        $res = $row['sum'];
    }
    else {
        $query = "select sum(hour) from discpl2hour  d2h
                  left join discpl2semestr d2s on (d2h.cdiscpl2semestr = d2s.id)
                  where ckindlesson in (1,2,3) and semestr = $sem and ctitle = $doc_id";
        $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
        $row =  pg_fetch_array($result);
        $res = $row['sum'];

    }
    return $res;
}
//возвращает общую трудоемкость дисциплины
//если $sem = 0, то считаем сумму всех часов по ВСЕМ семестрам, иначе по конкретному семестру
function queryForHourAll($doc_id, $sem){
    if ($sem == 0){
        $query = "select sum(hour) from discpl2hour  d2h
                  left join discpl2semestr d2s on (d2h.cdiscpl2semestr = d2s.id)
                  where ctitle = $doc_id";
        $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
        $row =  pg_fetch_array($result);
        $res = $row['sum'];
    }
    else {
        $query = "select sum(hour) from discpl2hour  d2h
                  left join discpl2semestr d2s on (d2h.cdiscpl2semestr = d2s.id)
                  where semestr = $sem AND ctitle = $doc_id";
        $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
        $row =  pg_fetch_array($result);
        $res = $row['sum'];
    }
    return $res;
}

?>


