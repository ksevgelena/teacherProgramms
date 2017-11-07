<?php
require_once 'db_connect.php';
$doc_id = $_GET['doc_id'];
$query = "select * from title2placeInStructur where ctitle = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$do = $row['doo'];
$posle  = $row['posle'];
?>
<form action="placeInStructur_upd.php" method="GET">
    <input  type="hidden" name = "doc_id" value =
    <?php
    echo "$doc_id >"
    ?>
    <h3>Место дисциплины в структуре ООП</h3>
    <div class = "podskazka">
        <h4>Обратите внимание</h4>
        <p>Каждую новую дисциплину начинать с новой строки. Наименования дисциплины вводить без кавычек. Если данных нет, оставьте поля пустыми.</p>
    </div>

    <label class="lab" style = "font-weight:bolder;">Обеспечивающие (предшествующие) дисциплины и практики:</label>
    <br><textarea name = "do" class="form-control" rows="6" placeholder=""><?php echo $do?></textarea>

    <label class="lab" style = "font-weight:bolder;">Обеспечиваемые (последующие) дисциплины и практики:</label>
    <br><textarea  name = "posle" class="form-control" rows="6" placeholder=""><?php echo $posle?></textarea>

    <div class = "col-md-12 boxbutton">
        <input type="submit" class="btn btn-primary" value="Сохранить">
        <input type="reset" class = "btn btn-default" value="Отмена">
    </div>
</form>
