<?php
/*
СТРУКТУРА ДИСЦИПЛИНЫ
*/
require_once 'db_connect.php';
$doc_id = $_GET['doc_id'];
$query = "select * from cattitle where id = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$discpl = $row['cdiscpl'];
$first_semestr = $row['first_semestr'];
$count_semestr = $row['count_semestr'];

//генерирование вкладок
$sem2 = "<li id=\"switcher2\" items=\"semestr2\" class=\"switcher_sm\"><a>Семестр ".($first_semestr + 1)."</a></li>";
$sem3 = "<li id=\"switcher3\" items=\"semestr3\" class=\"switcher_sm\"><a>Семестр ".($first_semestr + 2)."</a></li>";
$sem4 = "<li id=\"switcher4\" items=\"semestr4\" class=\"switcher_sm\"><a>Семестр ".($first_semestr + 3)."</a></li>";
$sem5 = "<li id=\"switcher5\" items=\"semestr5\" class=\"switcher_sm\"><a>Семестр ".($first_semestr + 4)."</a></li>";

//ЧАСЫ! данные из БД, если данные уже были внесены
$j = 0;
$discplHour  = array(); //в массиве $discplHour будут хранится пары данных:'порядковый номер (начиная с 1)' - 'hour', так как всего 5 семестров с 5 разными типами дисциплин = 25
$discplHour = array_pad($discplHour,26,'');
$kindAtt = array(); //массив с формой контроля (1 - экзамен,2 - зачет,3 - диф зачет,6 - отсутствует)
$kindAtt = array_pad($kindAtt,7,'');
$kindKurs = array(); //массив с формой контроля для курсовиков (4 - курсовая работа, 5 - курсовой проект, 6 - отсутствует)
$kindKurs = array_pad($kindKurs, 7, '');

$query = "select * from discpl2semestr ds left join discpl2hour dh on (dh.cdiscpl2semestr = ds.id) where ctitle = $doc_id order by (semestr, ckindlesson)";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
while ($row =  pg_fetch_array($result)){
        $j = $j+1;
        $discplHour[$j] = $row['hour'];
}
$j = 0;
$query = "select * from discpl2semestr ds where ctitle = $doc_id order by (semestr)";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
while ($row =  pg_fetch_array($result)) {
    $j = $j + 1;
    $kindAtt[$j]  = $row['cformcontr'];
    $kindKurs[$j] = $row['ckurs'];
}
?>
<div class = "col-md-9">
    <h3>Структура дисциплины "<?php echo $discpl?>"</h3>
    <form class = "form-inline" action="struktur_upd.php" method="GET">
        <fieldset>
            <p>Количество академических часов, выделенных на дисциплину <?php echo $discpl?> </p>
            <ul class="nav nav-tabs">
                <li id="switcher1" items="semestr1" class="switcher_sm active"><a>Семестр <?php echo $first_semestr?></a></li>
                <?php
                if ($count_semestr == 2) echo $sem2;
                if ($count_semestr == 3) echo $sem2, $sem3;
                if ($count_semestr == 4) echo $sem2, $sem3, $sem4;
                if ($count_semestr == 5) echo $sem2, $sem3, $sem4, $sem5;
                ?>
            </ul>
            <input  type="hidden" name = "doc_id" size=40 value =
            <?php
            echo "$doc_id>"
            ?>
<!--******Формочка 1 семестра********-->
            <div class = "structure_sem structure_sem1">
            <table class="table table-striped">
                <tbody>
                <tr>
                    <td width="70%">
                        Лекции
                    </td>
                    <td>
                        <input class = "form-control" name = "hourLek_sem1" type="text" placeholder="Часы" size = 6 value="<?php echo $discplHour[1]?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Лабораторные
                    </td>
                    <td>
                        <input class = "form-control" name = "hourLab_sem1" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[2]?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Практики/Семинары
                    </td>
                    <td>
                        <input class = "form-control" name = "hourPrakt_sem1" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[3]?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Самостоятельная работа(в т.ч. курсовое проектирование)
                    </td>
                    <td>
                        <input class = "form-control" name = "hourSam_sem1" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[4]?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Трудоемкость промежуточной аттестации
                    </td>
                    <td>
                        <input class = "form-control" name = "hourAtt_sem1" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[5]?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        Вид промежуточной аттестации
                    </td>
                    <td>
                            <select class="form-control select2" name = "kindAtt_sem1" placeholder="Вид аттестации">
                            <option value='6'>Отсутствует</option>
                            <?php
                            $query = 'SELECT * FROM cl$formcontr where id in (1,2,3)';
                            $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                            while ($row = pg_fetch_array($result)) {
                                if ($row['id']==$kindAtt[1]){
                                    echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                                else{
                                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                }
                            }
                            echo "</select>";
                            ?>

                           <br><select class="form-control select2" name = "kindAttKurs_sem1" placeholder="Курсовая работа">
                                <option value = '6'>Отсутствует</option>
                                    <?php
                                    $query = 'SELECT * FROM cl$formcontr where id in (4,5)';
                                    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                                    while ($row = pg_fetch_array($result)) {
                                        if ($row['id']==$kindKurs[1]){
                                            echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                        else{
                                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                    }
                                    echo "</select>";
                                    ?>
                    </td>
                </tr>
                </tbody>
            </table>
            </div>

<!--******Формочка 2 семестра********-->
            <div class = "structure_sem structure_sem2 hidden">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td width="70%">
                            Лекции 2 семестра
                        </td>
                        <td>
                            <input class = "form-control" name = "hourLek_sem2" type="text" placeholder="Часы" size = 6 value="<?php echo $discplHour[6]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Лабораторные
                        </td>
                        <td>
                            <input class = "form-control" name = "hourLab_sem2" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[7]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Практики/Семинары
                        </td>
                        <td>
                            <input class = "form-control" name = "hourPrakt_sem2" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[8]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Самостоятельная работа(в т.ч. курсовое проектирование)
                        </td>
                        <td>
                            <input class = "form-control" name = "hourSam_sem2" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[9]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Трудоемкость промежуточной аттестации
                        </td>
                        <td>
                            <input class = "form-control" name = "hourAtt_sem2" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[10]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Вид промежуточной аттестации
                        </td>
                        <td>
                            <select class="form-control select2" name = "kindAtt_sem2" placeholder="Вид аттестации">
                                <option value='6'>Отсутствует</option>
                                <?php
                                $query = 'SELECT * FROM cl$formcontr where id in (1,2,3)';
                                $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                                while ($row = pg_fetch_array($result)) {
                                    if ($row['id']==$kindAtt[2]){
                                        echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                    else{
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                echo "</select>";
                                ?>

                                <br><select class="form-control select2" name = "kindAttKurs_sem2" placeholder="Курсовая работа">
                                    <option value = '6'>Отсутствует</option>
                                    <?php
                                    $query = 'SELECT * FROM cl$formcontr where id in (4,5)';
                                    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                                    while ($row = pg_fetch_array($result)) {
                                        if ($row['id']==$kindKurs[2]){
                                            echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                        else{
                                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                    }
                                    echo "</select>";
                                    ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
 <!--******Формочка 3 семестра********-->
            <div class = "structure_sem structure_sem3 hidden">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td width="70%">
                            Лекции 3 семестра
                        </td>
                        <td>
                            <input class = "form-control" name = "hourLek_sem3" type="text" placeholder="Часы" size = 6 value="<?php echo $discplHour[11]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Лабораторные
                        </td>
                        <td>
                            <input class = "form-control" name = "hourLab_sem3" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[12]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Практики/Семинары
                        </td>
                        <td>
                            <input class = "form-control" name = "hourPrakt_sem3" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[13]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Самостоятельная работа(в т.ч. курсовое проектирование)
                        </td>
                        <td>
                            <input class = "form-control" name = "hourSam_sem3" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[14]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Трудоемкость промежуточной аттестации
                        </td>
                        <td>
                            <input class = "form-control" name = "hourAtt_sem3" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[15]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Вид промежуточной аттестации
                        </td>
                        <td>
                            <select class="form-control select2" name = "kindAtt_sem3" placeholder="Вид аттестации">
                                <option value='6'>Отсутствует</option>
                                <?php
                                $query = 'SELECT * FROM cl$formcontr where id in (1,2,3)';
                                $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                                while ($row = pg_fetch_array($result)) {
                                    if ($row['id']==$kindAtt[3]){
                                        echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                    else{
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                echo "</select>";
                                ?>

                                <br><select class="form-control select2" name = "kindAttKurs_sem3" placeholder="Курсовая работа">
                                    <option value = '6'>Отсутствует</option>
                                    <?php
                                    $query = 'SELECT * FROM cl$formcontr where id in (4,5)';
                                    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                                    while ($row = pg_fetch_array($result)) {
                                        if ($row['id']==$kindKurs[3]){
                                            echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                        else{
                                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                    }
                                    echo "</select>";
                                    ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
<!--******Формочка 4 семестра********-->
            <div class = "structure_sem structure_sem4 hidden">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td width="70%">
                            Лекции 4 семестра
                        </td>
                        <td>
                            <input class = "form-control" name = "hourLek_sem4" type="text" placeholder="Часы" size = 6 value="<?php echo $discplHour[16]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Лабораторные
                        </td>
                        <td>
                            <input class = "form-control" name = "hourLab_sem4" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[17]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Практики/Семинары
                        </td>
                        <td>
                            <input class = "form-control" name = "hourPrakt_sem4" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[18]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Самостоятельная работа(в т.ч. курсовое проектирование)
                        </td>
                        <td>
                            <input class = "form-control" name = "hourSam_sem4" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[19]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Трудоемкость промежуточной аттестации
                        </td>
                        <td>
                            <input class = "form-control" name = "hourAtt_sem4" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[20]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Вид промежуточной аттестации
                        </td>
                        <td>
                            <select class="form-control select2" name = "kindAtt_sem4" placeholder="Вид аттестации">
                                <option value='6'>Отсутствует</option>
                                <?php
                                $query = 'SELECT * FROM cl$formcontr where id in (1,2,3)';
                                $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                                while ($row = pg_fetch_array($result)) {
                                    if ($row['id']==$kindAtt[4]){
                                        echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                    else{
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                echo "</select>";
                                ?>

                                <br><select class="form-control select2" name = "kindAttKurs_sem4" placeholder="Курсовая работа">
                                    <option value = '6'>Отсутствует</option>
                                    <?php
                                    $query = 'SELECT * FROM cl$formcontr where id in (4,5)';
                                    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                                    while ($row = pg_fetch_array($result)) {
                                        if ($row['id']==$kindKurs[4]){
                                            echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                        else{
                                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                    }
                                    echo "</select>";
                                    ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
<!--******Формочка 5 семестра********-->
            <div class = "structure_sem structure_sem5 hidden">
                <table class="table table-striped">
                    <tbody>
                    <tr>
                        <td width="70%">
                            Лекции 5 семестра
                        </td>
                        <td>
                            <input class = "form-control" name = "hourLek_sem5" type="text" placeholder="Часы" size = 6 value="<?php echo $discplHour[21]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Лабораторные
                        </td>
                        <td>
                            <input class = "form-control" name = "hourLab_sem5" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[22]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Практики/Семинары
                        </td>
                        <td>
                            <input class = "form-control" name = "hourPrakt_sem5" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[23]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Самостоятельная работа(в т.ч. курсовое проектирование)
                        </td>
                        <td>
                            <input class = "form-control" name = "hourSam_sem5" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[24]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Трудоемкость промежуточной аттестации
                        </td>
                        <td>
                            <input class = "form-control" name = "hourAtt_sem5" type="text" placeholder="Часы" size=6 value="<?php echo $discplHour[25]?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Вид промежуточной аттестации
                        </td>
                        <td>
                            <select class="form-control select2" name = "kindAtt_sem5" placeholder="Вид аттестации">
                                <option value='6'>Отсутствует</option>
                                <?php
                                $query = 'SELECT * FROM cl$formcontr where id in (1,2,3)';
                                $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                                while ($row = pg_fetch_array($result)) {
                                    if ($row['id']==$kindAtt[5]){
                                        echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                    else{
                                        echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                    }
                                }
                                echo "</select>";
                                ?>

                                <br><select class="form-control select2" name = "kindAttKurs_sem5" placeholder="Курсовая работа">
                                    <option value = '6'>Отсутствует</option>
                                    <?php
                                    $query = 'SELECT * FROM cl$formcontr where id in (4,5)';
                                    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                                    while ($row = pg_fetch_array($result)) {
                                        if ($row['id']==$kindKurs[5]){
                                            echo "<option selected value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                        else{
                                            echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                                        }
                                    }
                                    echo "</select>";
                                    ?>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class = "col-md-12 boxbutton" >
                <input type="submit" class="btn btn-primary" value="Сохранить">
                <input type="reset" class = "btn btn-default" value="Отмена">
            </div>
        </fieldset>
    </form>
</div>






