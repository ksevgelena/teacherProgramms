<?php
require_once 'db_connect.php';
$doc_id = $_GET['doc_id'];
$query = "select * from title2zadachi where ctitle = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$celi = $row['celi'];
$zad  = $row['zadachi']
?>
<form action="zadachi_upd.php" method="GET">
    <input  type="hidden" name = "doc_id" value =
    <?php
    echo "$doc_id >"
    ?>
    <h3>Цели и задачи</h3>
    <p>Здесь необходимо заполнить сведения о целях и задачах дисциплины. Каждую новую цель или задачу необходимо начинать с новой строки.</p>
    <label class="lab" style = "font-weight:bolder;">Цели изучения дисциплины</label>
    <br><textarea name = "cel" class="form-control" rows="6" placeholder="Целью изучения дисциплины являются..."><?php echo $celi?></textarea>

    <label class="lab" style = "font-weight:bolder;">Задачи изучения дисциплины</label>
    <br><textarea  name = "zad" class="form-control" rows="6" placeholder="Основными задачами являются..."><?php echo $zad?></textarea>
    <div class = "col-md-12 boxbutton">
        <input type="submit" class="btn btn-primary" value="Сохранить">
        <input type="reset" class = "btn btn-default" value="Отмена">
    </div>
</form>