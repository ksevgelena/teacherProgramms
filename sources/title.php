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
        <div class="h1">ГЕНЕРАТОР РАБОЧИХ ПРОГРАММ ИРНИТУ</div>

        <div class="h4">
            <ul class="nav nav-pills">
                <li role="presentation" class="active"><a href="all_programms.php">Все программы</a></li>
                <li role="presentation"><a href="doc_word.php?doc_id=<?php echo $_GET['doc_id_'];?>;">Выгрузить</a></li>
                <li role="presentation"><a href="#">Справка</a></li>
            </ul>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="list-group" id = "leftmenu">
                    <a href="#" class="list-group-item" id = "button_title">
                        <span class="glyphicon glyphicon-hand-right"></span> Титульный лист</span>
                    </a>
                    <a href="#" class="list-group-item" id = "button_zadachi">
                        <span class="glyphicon glyphicon-file"></span> Цели и задачи </span>
                    </a>
                    <a href="#" class="list-group-item" id = "button_resultOsvoen">
                        <span class="glyphicon glyphicon-ok-circle"></span> Результаты освоения дисциплины </span>
                    </a>
                    <a href="#" class="list-group-item" id = "button_placeInStructur">
                        <span class="glyphicon glyphicon-file"></span> Место дисц-ины в структуре ООП </span>
                    </a>
                    <a href="#" class="list-group-item" id = "button_struktur">
                        <span class="glyphicon glyphicon-file"></span> Структура дисциплины </span>
                    </a>
                    <a href="#" class="list-group-item" id = "button_soderLek">
                        <span class="glyphicon glyphicon-file"></span> Содержание лекционных занятий </span>
                    </a>
                    <a href="#" class="list-group-item" id = "button_soderPract">
                        <span class="glyphicon glyphicon-file"></span> Содержание практических занятий </span>
                    </a>
                    <a href="#" class="list-group-item">
                        <span class="glyphicon glyphicon-file"></span> Содержание самостоятельной работы </span>
                    </a>
                    <a href="#" class="list-group-item" id = "button_kompetent">
                        <span class="glyphicon glyphicon-file"></span> Соответствие компетенций </span>
                    </a>
                </div>
            </div>

            <div class="col-md-9" id = "form_title">
            </div>
        </div>

        <div class="footer">Footer</div>
    </div>
    <script>
        var $doc_id = <?php echo $_GET['doc_id_'];?>;
        $(document).ready(function () {

            /*Заполнение титульного листа*/
            $("#button_title").click(function () {
                $("#leftmenu a").removeClass('active');
                $("#leftmenu a span").removeClass('glyphicon-hand-right');
                $(this).addClass('active');

                $('#form_title').html("Wait for data ...");
                $.ajax({
                    url: "titleform.php?doc_id=" + $doc_id + "&action=get",
                    success: function (html) {
                        $('#form_title').html(html.toString());
                        $(".select2").select2({
                            allowClear: true
                        });
                    }
                });
            });
            $("#button_title").trigger('click');

            /*Заполнение целей и задач*/
            $("#button_zadachi").click(function () {
                $("#leftmenu a").removeClass('active');
                $(this).addClass('active');
                $('#form_title').html("Wait for data ...");
                $.ajax({
                    url: "zadachi.php?doc_id=" + $doc_id + "&action=get",
                    success: function (html) {
                        $('#form_title').html(html.toString());
                        $(".select2").select2({
                            allowClear: true
                        });
                    }
                });
            });
            /*Заполнение результатов освоения дисциплины*/
            $("#button_resultOsvoen").click(function () {
                $("#leftmenu a").removeClass('active');
                $(this).addClass('active');
                $('#form_title').html("Wait for data ...");
                $.ajax({
                    url: "resultOsvoen.php?doc_id=" + $doc_id + "&action=get",
                    success: function (html) {
                        $('#form_title').html(html.toString());
                        $(".select2").select2({
                            allowClear: true
                        });
                    }
                });
            });
            /*Заполнение места дисциплины в структуре ООП*/
            $("#button_placeInStructur").click(function () {
                $("#leftmenu a").removeClass('active');
                $(this).addClass('active');
                $('#form_title').html("Wait for data ...");
                $.ajax({
                    url: "placeInStructur.php?doc_id=" + $doc_id + "&action=get",
                    success: function (html) {
                        $('#form_title').html(html.toString());
                        $(".select2").select2({
                            allowClear: true
                        });
                    }
                });
            });
            /*Заполнение компетенций*/
            $("#button_kompetent").click(function () {
                $("#leftmenu a").removeClass('active');
                $(this).addClass('active');
                $('#form_title').html("Wait for data ...");
                $.ajax({
                    url: "kompetentform.php?doc_id=" + $doc_id + "&action=get",
                    success: function (html) {
                        $('#form_title').html(html.toString());
                        $(".select2").select2({
                            allowClear: true
                        });
                    }
                });
            });
            /*Заполнение структуры программы*/
            $("#button_struktur").click(function () {
                $("#leftmenu a").removeClass('active');
                $(this).addClass('active');
                $('#form_title').html("Wait for data ...");
                $.ajax({
                    url: "strukturform.php?doc_id=" + $doc_id + "&action=get",
                    success: function (html) {
                        $('#form_title').html(html.toString());
                        $(".select2").select2({
                            allowClear: true
                        });
                    }
                });
            });
            /*Заполнение содержания лекционных занятий*/
            $("#button_soderLek").click(function () {
                $("#leftmenu a").removeClass('active');
                $(this).addClass('active');
                $('#form_title').html("Wait for data ...");
                $.ajax({
                    url: "soderLek.php?doc_id=" +$doc_id+ "&action=get",
                    success: function (html) {
                        $('#form_title').html(html.toString());
                        $(".select2").select2({
                            allowClear: true
                        });
                    }
                });
            });
            /*Заполнение содержания практических занятий*/
            $("#button_soderPract").click(function () {
                $("#leftmenu a").removeClass('active');
                $(this).addClass('active');
                $('#form_title').html("Wait for data ...");
                $.ajax({
                    url: "soderPract.php?doc_id=" +$doc_id+ "&action=get",
                    success: function (html) {
                        $('#form_title').html(html.toString());
                        $(".select2").select2({
                            allowClear: true
                        });
                    }
                });
            });
        })
    </script>
</body>
</html>