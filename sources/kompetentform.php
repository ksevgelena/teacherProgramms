<?php
require_once 'db_connect.php';
$doc_id = $_GET['doc_id'];
$query = "select * from cattitle t left join title2kompetent k on t.id = k.ctitle where t.id = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$array = array();
//TODO сделать счетчик выбранных компетенций
$countAll = 0; //общее количество выбранных компетенций
$countOK = 0; //количесвто выбранных ок
$countPK = 0; //количество выбранных пк
//заполнение в массив $array уже выбранных компетенций из БД
while ($row = pg_fetch_array($result)) {
    array_push($array, $row['ckompetent']);
    $discpl = $row['cdiscpl'];
    }
?>
<h3>Заполнение компетенций</h3>
<p>Выберите общекультурные компетенции (ОК) и профессиональные компетенции (ПК), которыми должен обладать выпускник после изучения дисциплины "<?php echo $discpl?>".</p>
<div class="col-md-12">
    <ul class="nav nav-tabs">
        <li id="ok_switcher" items="ok_item" class="switcher active"><a>Oбщекультурные</a></li>
        <li id="pk_switcher" items="pk_item" class="switcher"><a>Профессиональные</a></li>
    </ul>
    <form action="komp_upd.php" method="GET">
        <input  type="hidden" name = "doc_id" value =
        <?php
        echo "$doc_id >"
        ?>
        <div class="k_item ok_item" style="height: 650px; overflow: scroll;">
            <h4>Выпускник должен обладать следующими общекультурными компетенциями (ОК)</h4>
            <div class="checkbox">
                <table class="table table-striped">
                    <tbody>
                    <?php
                    $query = 'SELECT * FROM catkompetent where ckindkompetent = \'ОК\' order by nomer';
                    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                   while ($row = pg_fetch_array($result)) {
                        if (in_array($row['id'],$array)){
                            echo "<tr><td><label><input name=\"int_kompetent[]\" type=\"checkbox\" value = ".$row['id']." checked>".$row['ckindkompetent']."-".$row['nomer']." ".$row['name']."</label></td></tr>";
                        }
                        else{
                            echo "<tr><td><label><input name=\"int_kompetent[]\" type=\"checkbox\" value = ".$row['id'].">".$row['ckindkompetent']."-".$row['nomer']." ".$row['name']."</label></td></tr>";
                        }
                      }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="k_item pk_item hidden" style="height: 650px; overflow: scroll;">
            <h4>Выпускник должен обладать следующими профессиональными компетенциями (ПК)</h4>
            <div class="checkbox">
                <table class="table table-striped">
                    <tbody>
                    <?php
                    $query = 'SELECT * FROM catkompetent where ckindkompetent = \'ПК\' order by nomer';
                    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                    while ($row = pg_fetch_array($result)) {
                        if (in_array($row['id'],$array)){
                            echo "<tr><td><label><input name=\"int_kompetent[]\" type=\"checkbox\" value = ".$row['id']." checked>".$row['ckindkompetent']."-".$row['nomer']." ".$row['name']."</label></td></tr>";
                        }
                        else{
                            echo "<tr><td><label><input name=\"int_kompetent[]\" type=\"checkbox\" value = ".$row['id'].">".$row['ckindkompetent']."-".$row['nomer']." ".$row['name']."</label></td></tr>";
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <input type="submit" class="btn btn-primary" value="Сохранить">
        <input type="reset" class = "btn btn-default" value="Отмена">
    </form>
</div>

