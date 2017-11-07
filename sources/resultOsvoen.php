<?php
require_once 'db_connect.php';
$doc_id = $_GET['doc_id'];
$query = "select * from title2resultosvoen where ctitle = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$znat = $row['znat'];
$umet  = $row['umet'];
$vladet  = $row['vladet'];
?>
<form action="resultOsvoen_upd.php" method="GET">
    <input  type="hidden" name = "doc_id" value =
    <?php
    echo "$doc_id >"
    ?>
    <h3>Результат освоения дисциплины</h3>
    <p>В результате освоения дисциплины студенты должны:</p>
    <label class="lab" style = "font-weight:bolder;">Знать</label>
    <br><textarea name = "znat" class="form-control" rows="6" placeholder=""><?php echo $znat?></textarea>

    <label class="lab" style = "font-weight:bolder;">Уметь</label>
    <br><textarea  name = "umet" class="form-control" rows="6" placeholder=""><?php echo $umet?></textarea>

    <label class="lab" style = "font-weight:bolder;">Владеть</label>
    <br><textarea  name = "vladet" class="form-control" rows="6" placeholder=""><?php echo $vladet?></textarea>
    <div class = "col-md-12 boxbutton">
        <input type="submit" class="btn btn-primary" value="Сохранить">
        <input type="reset" class = "btn btn-default" value="Отмена">
    </div>
</form>