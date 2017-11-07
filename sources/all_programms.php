<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <script src="http://code.jquery.com/jquery-1.12.1.js"></script>
    <!--script type="text/javascript" src="script2.js"></script-->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-css/1.4.6/select2-bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="myframework.js"></script>
    <title>Hello world</title>
</head>
<body>
<div class="wrapper">
    <div class="h1">ГЕНЕРАТОР РАБОЧИХ ПРОГРАММ
        <abbr title="Иркутский Национальный Технический Университет">ИРНИТУ</abbr>
    </div>

    <div class="h4">
        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="#">Все программы</a></li>
            <li role="presentation"><a href="#">Дисциплина "Базы данных"</a></li>
            <li role="presentation"><a href="#">Справка</a></li>
        </ul>
    </div>
    <div class="col-md-4">
             <?php
                    require_once 'db_connect.php';
                    $query = 'SELECT * FROM cattitle where creater = 1 and delete = \'f\'';
                    $result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
                    while ($row = pg_fetch_array($result)) {
                        echo  "<div class=\"btn-group\" style = \" margin: 2px;\">
                                  <button href=\"title.php?doc_id_=",$row['id'],"\" class=\"btn btn-default\" type=\"button\" style=\"width: 300px; text-align: left;\" id = \"list_discpl",$row['id'], "\">", $row['cdiscpl'],"</button>
                                  <button href='#delete_prog' type=\"button\" class=\"btn btn-default\" data-toggle=\"modal\" onclick=\"toModalForDel(",$row['id'],", '" , $row['cdiscpl'],"')\" name = \"del-prog\"><span class=\"glyphicon glyphicon-trash\"></span></button>
                                </div>";}
             ?>
    </div >

    <div class="col-md-6" id = "prog">
        <a href="#add_new_prog" class="btn btn-info" data-toggle="modal">Добавить новую рабочую программу</a>
    </div>

</div>
<script>
   /* $(document).ready(function () {
            $("#new_prog").click(function () {
                $(this).addClass('active');
                $('#form_title').html("Wait for data ...");
                $.ajax({
                    url: "programm_new.php?doc_id=1&action=get",
                    success: function (html) {
                        $('#prog').html(html.toString());
                    }
                });
            });
        }
    )
    $(document).ready(function () {
            $("#new_prog").click(function () {
                $('#add_new_prog').modal('show');
            });
        }
    )*/
</script>

<!-- Модальное окно при добалении новой рабочей программы -->
<div class="modal fade" id="add_new_prog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-danger">
                <button class="close" type="button" data-dismiss="modal"></button>
                <h4 class="modal-title">Введите наименование дисциплины:</h4>
            </div>
            <div class="modal-body">
                <form action = "prog_ins.php" metod = "GET">
                    <div class="col-md-5" style ="margin-left: 30px;">
                        <label>Наименование дисциплины</label>
                        <input name = "discpl" type="text" placeholder="Введите текст" size=40>
                        <button class="btn btn-primary" type="submit" id = "new-prog">Создать</button>
                        <button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно при удалении рабочей программы -->
<div class="modal fade" id="delete_prog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header text-danger">
                <button class="close" type="button" data-dismiss="modal"><i class="fa fa-close"></i></button>
                <h4 class="modal-title">Удаление рабочей программы</h4>
            </div>
            <div class="modal-body">
                <form success="myattr">
                        <!-- TODO добавить наименование дисциплины в вопросе -->
                    <p>Вы уверены, что хотите удалить рабочую программу по дисциплине "<span id="nameProgForDel"></span>"?</p>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" id = "deleteProg" href="prog_del"">Удалить</button>
                <button class="btn btn-default" type="button" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>


<script>
    function myattr(val) {
        $val = val;
        $queryProg = 'insert into cattitle (discpl) values (\"' + $discpl + '\")';
        $.ajax({
            url: "title_bd.php?val="+$val+"&action=get",
            success: function (html) {
                $('#form_title').html(html.toString());
                alert($queryProg)
            }
        })
    $(document).ready(function () {
        $('#new-prog').click(function () {
            var $form = $('form');
            alert ($form.attr('success'));
            alert($('input[name=discpl]').val());
            eval($form.attr('success'))($('input[name=discpl]').val());
        })
    })
</script>

</body>
</html>