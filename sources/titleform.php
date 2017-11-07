<?php
require_once 'db_connect.php';
/*if (isset( $_GET['doc_id'])){$doc_id = $_GET['doc_id'];}
if (isset( $_GET['doc_id_'])){$doc_id = $_GET['doc_id_'];}

echo $doc_id;*/
$doc_id = $_GET['doc_id'];
$query = "select * from cattitle where id = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$discpl = $row['cdiscpl'];
$kaf = $row['ckaf'];
$fac = $row['cfac'];
$count_semestr = $row['count_semestr'];
$first_semestr = $row['first_semestr'];
?>


    <h3>Титульный лист</h3>
    <p>Рабочая программа по дисциплине "<?php echo "$discpl"?>" составлена с учетом требований Федерального
        Государственного образователдьного
        стандарта высшего профессионального образования (ФГОС ВПО).</p>
    <p>Первым шагом генерации рабочей программы необходимо заполнить следующие данные о дисциплине:</p>
    <form action="prog_upd.php" method="GET" class = "form-inline">
        <h4 class = "line">Данные о дисциплине</h4>
        <div class="col-md-5 form-group"">
            <fieldset>
                <input  type="hidden" name = "doc_id" size=40 value =
                <?php
                echo "$doc_id >"
                ?>
                <label class="lab">Наименование дисциплины</label>
                <input class = "title form-control" name = "discpl" type="text" placeholder="Введите текст" size=40 value ="<?php echo "$discpl\">"?>

                <label class="lab">Институт</label>
                <select name = "cfac" class="form-control select2">
                    <option disabled></option>
                    <?php
                    $query = 'SELECT * FROM catfaculty order by name';
                    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                    while ($row = pg_fetch_array($result)) {
                        if ($row['id']==$fac){
                            echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                        else{
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                        }
                    }
                    echo "</select>";
                    ?>
                </select>
                <label class="lab">Кафедра</label>
                <br><select name = "ckaf" class="form-control select2">
                    <option disabled></option>
                    <?php
                    $query = 'SELECT * FROM catkaf order by name';
                    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                     while ($row = pg_fetch_array($result)) {
                         if ($row['id']==$fac){
                             echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                         }
                         else{
                             echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                         }
                     }
                    echo "</select>";
                    ?>
                </select>

                <label class="lab">Год набора</label>
                <input class = "title form-control" name = "yr_nabor" type="text" placeholder="Введите текст" size=40>

                <label class="lab">Профиль</label>
                <input class = "title form-control" name = "profil" type="text" placeholder="Введите текст" size=40>
           </fieldset>
        </div>

        <div class="col-md-1"></div>

        <div class="col-md-5">
            <fieldset>
                <label class="lab">Наименование направления</label>
                <input class = "title form-control" name = "cdirection" type="text" placeholder="Введите текст" size=40>

                <label class="lab">Уровень подготовки</label>
                <input class = "title form-control" name = "cadmkind" type="text" placeholder="Введите текст" size=40>

                <br><label class="lab">Форма обучения</label>
                <br><select name = "cset" class="form-control select2"  name="forma_obuch">
                    <option disabled></option>
                    <?php
                        $query = 'SELECT * FROM catfaculty';
                        $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                        // echo "<select name = 'form_ob'>";
                        while ($row = pg_fetch_array($result)) {
                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";}
                        echo "</select>";
                        ?>
                </select>
                <label class="lab">Дата утверждения ФГОС</label>
                <br><input class = "title form-control" name = "date_FGOS" type="date">
                <br><label class="lab">Цикл дисциплины</label>
                <input class = "form-control" name = "cycle_discpl" type="text" placeholder="Введите текст" size=40>

            </fieldset>
        </div>
        <div class = "col-md-12">
            <h4 class = "line">Данные о семестре</h4>
            <label class="lab">Количество семестров</label>
            <input class = "title form-control" name = "count_semestr" type="number" pattern = "\d[1-5]" value = "<?php echo "$count_semestr\">"?> <!--ограничение не работает (pattern = "\d[1-5]") -->
            <label class="lab">Начальный семестр</label>
            <input class = "title form-control" name = "first_semestr" type="number" pattern = "\d[1-8]" value = "<?php echo "$first_semestr\">"?>
      </div>
       <div class = "col-md-12 boxbutton" >
           <input type="submit" class="btn btn-primary" value="Сохранить">
           <input type="reset" class = "btn btn-default" value="Отмена">
       </div>
    </form>



