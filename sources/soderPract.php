<?php
//СОДЕРЖАНИЕ ПРАКТИЧЕСКИХ ЗАНЯТИЙ
require_once 'db_connect.php';
$doc_id = $_GET['doc_id'];
$query = "select * from cattitle where id = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: '.pg_last_error());
$row = pg_fetch_array($result);
$discpl = $row['cdiscpl'];

$query = "select * from discpl2lek d2l
left join discpl2semestr d2s on (d2l.cdiscpl2semestr = d2s.id)
where ctitle = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: '.pg_last_error());
while ($row =  pg_fetch_array($result)){

}

?>
<div>
    <h3>Перечень практических занятий по дисциплине "<?php echo $discpl?>"</h3>
    <form action="soderPract_upd.php" method="GET">
        <div class = "dobavlenieStroki col-md-11">
            <h3>Добавление нового практического занятия</h3>
            <input  type="hidden" name = "doc_id" size=40 value =
            <?php
            echo "$doc_id>"
            ?>

            <label class="lab">Наименование практического занятия</label>
            <br><input class = "title form-control" name = "temaPract" type="text" placeholder="Введите текст" size=40>

            <div>
                <label class="lab">Тема дисциплины</label> <br>
                <select  name = "temaDiscpl" class = "form-control select2">
                    <?php
                    $query = "select * from discpl2lek d2l
                    left join discpl2semestr d2s on (d2l.cdiscpl2semestr = d2s.id)
                    where ctitle = $doc_id";
                    $result = pg_query($query) or die('Ошибка запроса: '.pg_last_error());
                    while ($row =  pg_fetch_array($result)){
                        echo "<option value=\"".$row['d2l.id']."\">Семестр ".$row['semestr'].". ".$row['tema']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class = "col-md-5" style = "padding: 0;">
                <label class="lab">Интерактивные технологии</label><br>

                <select  name = "interPract" class = "form-control select2">
                    <?php
                    $query = "select * from cl\$intertechnology";
                    $result = pg_query($query) or die('Ошибка запроса: '.pg_last_error());
                    while ($row =  pg_fetch_array($result)){
                        echo "<option value=\"".$row['id']."\">".$row['name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="col-md-2">
                <label class="lab">Кол-во часов</label> <br>
                <input class = "title form-control" name = "temaPract" type="number">
            </div>
            <div class="col-md-2">
                <label class="lab">П/п номер</label> <br>
                <input class = "title form-control" name = "numPract" type="number">
            </div>
            <div  class = "col-md-12" style = "text-align:right" >
                <input type="submit" class="btn btn-primary" value="Сохранить">
                <input type="reset" class = "btn btn-default" value="Отмена">
            </div>
        </div>
    </form>
</div>
