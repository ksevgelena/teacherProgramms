/**
 * Created by skoklenevaep on 31.08.2017.
 */
var idProgForDelete;


/**
 *  Для <button ... > переход по ссылке в атрибуте href
 *  Например:
 *    <button href="http://www.istu.edu" type="button" class="btn btn-default">Поднимающееся меню</button>
 * */
$(document).ready(function () {
    $('button[href]').click(function () {
        location.href = $(this).attr('href');
    });
});

/*
 * Реализация смены вкладок при выборе компетенций (ПК или ОК), kompetentform.php
 * */
$(document).on('click','#ok_switcher', function(){
        $(".switcher").removeClass("active");
        $("#ok_switcher").addClass("active");

        $(".k_item").addClass("hidden");
        $(".ok_item").removeClass("hidden");
});

$(document).on('click','#pk_switcher', function(){
    $(".switcher").removeClass("active");
    $("#pk_switcher").addClass("active");

    $(".k_item").addClass("hidden");
    $(".pk_item").removeClass("hidden");
});
/*
 * Реализация смены вкладок при заполении часов в семестре во вклдаке Структура дисциплины, structurform.php
 * */
//вкладка 1 семестра
$(document).on('click','#switcher1', function(){
    $(".switcher_sm").removeClass("active");
    $("#switcher1").addClass("active");

    $(".structure_sem").addClass("hidden");
    $(".structure_sem1").removeClass("hidden");
});
//вкладка 2 семестра
$(document).on('click','#switcher2', function(){
    $(".switcher_sm").removeClass("active");
    $("#switcher2").addClass("active");

    $(".structure_sem").addClass("hidden");
    $(".structure_sem2").removeClass("hidden");
});
//вкладка 3 семестра
$(document).on('click','#switcher3', function(){
    $(".switcher_sm").removeClass("active");
    $("#switcher3").addClass("active");

    $(".structure_sem").addClass("hidden");
    $(".structure_sem3").removeClass("hidden");
});
//вкладка 4 семестра
$(document).on('click','#switcher4', function(){
    $(".switcher_sm").removeClass("active");
    $("#switcher4").addClass("active");

    $(".structure_sem").addClass("hidden");
    $(".structure_sem4").removeClass("hidden");
});
//вкладка 5 семестра
$(document).on('click','#switcher5', function(){
    $(".switcher_sm").removeClass("active");
    $("#switcher5").addClass("active");

    $(".structure_sem").addClass("hidden");
    $(".structure_sem5").removeClass("hidden");
});



/*
* Подстановка наимнования программы при ее удалении (all_programms.php)
* */
function toModalForDel(idDiscpl, nameDiscpl) {
    var progForDel = document.getElementsByName('del-prog');
  /* var pp = progForDel.getAttribute('id_prog');*/
    document.getElementById("nameProgForDel").innerHTML = nameDiscpl;
    document.getElementById("deleteProg").setAttribute('href', 'prog_del.php?doc_id='+idDiscpl);
}


function deleteFromDB(idVal, table) {
    
}

