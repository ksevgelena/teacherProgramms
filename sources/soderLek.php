<?php
//СОДЕРЖАНИЕ ЛЕКЦИОННЫХ ЗАНЯТИЙ
require_once 'db_connect.php';
$doc_id = $_GET['doc_id'];
$query = "select * from cattitle where id = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: '.pg_last_error());
$row = pg_fetch_array($result);
$discpl = $row['cdiscpl'];
$first_semestr = $row['first_semestr'];
$count_semestr = $row['count_semestr'];
if ($count_semestr == 1) {
    $typeSemestr = 'hidden';
    $typeSemestrLabel = 'hidden';
}
else {
    $typeSemestr = 'number';
    $typeSemestrLabel = 'visible';
}

$query = "select * from discpl2semestr where ctitle = $doc_id order by semestr";
$result = pg_query($query) or die('Ошибка запроса: '.pg_last_error());
$semestr  = array();
$j = 0;
while ($row =  pg_fetch_array($result)){
    $j = $j+1;
    $semestr[$j] = $row['semestr'];
}
?>

<div>
    <h3>Содержание лекционных занятий по дисциплине "<?php echo $discpl?>"</h3>
    <form id="form_new_lesson" action="soderLek_upd.php" method="GET">
        <div class = "dobavlenieStroki col-md-11">
            <h3>Добавление новой темы</h3>
            <input  type="hidden" id="new_lesson_doc_id" name = "doc_id" size=40 value =
                <?php
                    echo "$doc_id>"
                ?>
            <label class="lab">Наименование раздела и темы дисциплины</label>
            <br><input class = "title form-control" id = "new_lesson_temaDiscpl" name = "temaDiscpl" type="text" placeholder="Введите текст" size=40 >

            <div class="col-md-3" style = "padding: 0;">
                <label class="lab">Количество часов лекций</label>
                <input  style = "width: 90%" class = "form-control" id = "new_lesson_hourLekForTems" name = "hourLekForTems" type="number">
            </div>

            <div class = "col-md-2" >
            <label class="lab" style = "visibility: <?php echo $typeSemestrLabel?>;">Семестр</label> <br>
            <select  class = "form-control select2" id = "new_lesson_semestrForTems" name = "semestrForTems" type= "<?php echo $typeSemestr?>">
                <?php foreach ($semestr as $value){echo "<option value=\"".$value."\">".$value."</option>";}?>
            </select>
           </div>

            <div class="col-md-2">
                <label class="lab">П/п номер</label> <br>
                <input class = "title form-control" id = "new_lesson_numLek" name = "numLek" type="number">
            </div>

           <div  class = "col-md-12" style = "text-align:right" >
                <input type="submit" class="btn btn-primary" value="Сохранить">
                <input id="nope_button" type="reset" class = "btn btn-default" value="Отмена">
            </div>
        </div>
    </form>

<div class="col-md-12">
    <ul class="nav nav-tabs">
        <li id="sw" items="sem1" class="switcher_sm active"><a>Семестр</a></li>
        <?php
        foreach ($semestr as $value){
            echo "<li id=\"sw\" items=\"sem1\" class=\"switcher_sm\"><a>"."Семестр ".$value."</a></li>";
        }
        ?>
    </ul>
</div>









    <div class="progress progress-striped col-md-11" style = "padding: 0;">
        <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%">
            <span class="sr-only">40% Complete (success)</span>
        </div>
    </div>
    <div class = "col-md-11" style = "padding: 0;">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>№</th>
                <th>Наименование раздела и темы дисциплины</th>
                <th>Кол-во часов</th>
                <th>Семестр</th>
            </tr>
            </thead>
            <tbody>
                <?php
                $query = "select * from discpl2lek d2l left join discpl2semestr d2s on (d2s.id = d2l.cdiscpl2semestr) where ctitle = $doc_id ORDER by semestr, num";
                $result = pg_query($query) or die('Ошибка запроса: '.pg_last_error());
                $j = 0;
                while ($row =  pg_fetch_array($result)){
                    echo "<tr><td>".$row['num']."</td>";
                    echo "<td>".$row['tema']."</td>";
                    echo "<td>".$row['hour']."</td>";
                    echo "<td>".$row['semestr']."</td>";
                    echo "<td width=\"8%\"><button type=\"button\" class=\"btn btn-default btn-xs\"><span class=\"glyphicon glyphicon-pencil\"></span></button><button type=\"button\" class=\"btn btn-default btn-xs\"><span class=\"glyphicon glyphicon-trash\"></span></button></td></tr>";
                };
                ?>
            </tbody>
        </table>
    </div>
</div>


