<?php
require 'PhpWord/PHPWord.php';
require_once "vendor/autoload.php";
require_once 'db_connect.php';
require_once 'myFunction.php';

$doc_id = $_GET['doc_id'];
$query = "select f.name as fac, k.name as kaf, * from cattitle t
          left join catfaculty f on (f.id = t.cfac)
          left join catkaf k on (k.id = t.ckaf)
          where t.id = $doc_id";

$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$discpl = $row['cdiscpl'];
$kaf = $row['kaf'];
$fac = $row['fac'];
$count_semestr = $row['count_semestr'];
$first_semestr = $row['first_semestr'];
$director = $row['director'];

/*выбираем компетенции из таблиц catkompetent, title2kompetent*/
$kompetentName = array();
$kompetentNum = array();
$kompetentAbbr = array();
$query = "select * from catkompetent k
          left join title2kompetent tk on (k.id = tk.ckompetent)
          where ctitle = $doc_id";

$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
while ($row =  pg_fetch_array($result)){
       $kompetentName[] = $row['name'];
       $kompetentNum[]  = $row['nomer'];
       $kompetentAbbr[] = $row['ckindkompetent'];
}
/*цели и задачи*/
$query = "select * from title2zadachi
          where ctitle = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$zadachi = $row['zadachi'];
$celi    = $row['celi'];

/*Результаты освоения дисциплины (знать, уметь, владеть)*/
$query = "select * from title2resultosvoen
          where ctitle = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$znat   = $row['znat'];
$umet   = $row['umet'];
$vladet = $row['vladet'];

/*Место дисциплины в стуркутре ООП*/
$query = "select * from title2placeinstructur
          where ctitle = $doc_id";
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());
$row =  pg_fetch_array($result);
$posle = $row['posle'];
$doo   = $row['doo'];

$word = new \PhpOffice\PhpWord\PhpWord();

$word->setDefaultFontName('Times New Roman');
$word->setDefaultFontSize(14);

$properties = $word->getDocInfo();
$properties->setCreator('LENA');

/*Настройка полей*/
$sectionStyle = array(
                       'pageNumberingStart' => 1,
                       'marginTop'=>1133,
                       'marginLeft'=>1700,
                       'marginRight'=>850,
                       'marginBottom'=>1133
                        );
$section = $word->addSection($sectionStyle);

/*ФОРМИРОВАНИЕ ТИТУЛЬНОГО ЛИСТА*/

$section->addText(htmlspecialchars("Министерство образования и науки  Российской Федерации"), /*текст*/
                  array('bold'=>true),                                                               /*шрифт*/
                  array('align'=>'center', 'spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>200)                                                           /*абзац*/
                  );

$section->addText("Федеральное государственное бюджетное образовательное учреждение высшего образования",
                  array('bold'=>true),
                  array('align'=>'center', 'spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>200)
                 );

$section->addText("«ИРКУТСКИЙ НАЦИОНАЛЬНЫЙ ИССЛЕДОВАТЕЛЬСКИЙ ТЕХНИЧЕСКИЙ УНИВЕРСИТЕТ»",
    array('bold'=>true),
    array('align'=>'center', 'spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>200)
);

$section->addText($fac,
    array(),
    array('align'=>'center', 'spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>200)
);

$section->addText("Кафедра ".$kaf,
    array(),
    array('align'=>'center','spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>200)
);

$section->addText("утверждаю:",
    array('bold'=>true,  'allCaps'=> true),
    array('align'=>'right','spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>0)
);

$section->addText("Директор института",
    array('bold'=>false,),
    array('align'=>'right', 'spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>0)
);

$section->addText($director,
    array('bold'=>false, 'underline'=>'single'),
    array('align'=>'right','spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>0)
);

$section->addText('«_____» __________ '.date('Y').' г.',
    array('bold'=>false),
    array('align'=>'right','spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>0)
);

$section->addText('рабочая программа дисциплины',
    array('bold'=>true, 'allCaps'=>true),
    array('align'=>'center','spacing'=>60,'spaceBefore'=>150, 'spaceAfter'=>0)
);

$section->addText("«".$discpl."»",
    array('bold'=>false, 'allCaps'=>true),
    array('align'=>'center','spacing'=>60,'spaceBefore'=>150, 'spaceAfter'=>0)
);

$section->addText("Направление подготовки:",
    array(),
    array('align'=>'left','spacing'=>60,'spaceBefore'=>700, 'spaceAfter'=>0)
);

$section->addText("Программа подготовки:",
    array(),
    array('align'=>'left','spacing'=>60,'spaceBefore'=>150, 'spaceAfter'=>0)
);

$section->addText("Квалификация:",
    array(),
    array('align'=>'left','spacing'=>60,'spaceBefore'=>150, 'spaceAfter'=>0)
);

$section->addText("Форма обучения:",
    array(),
    array('align'=>'left','spacing'=>60,'spaceBefore'=>150, 'spaceAfter'=>0)
);

$section->addText("Составитель программы:",
    array('bold'=>true),
    array('align'=>'left','spacing'=>60,'spaceBefore'=>350, 'spaceAfter'=>150)
);

/*Таблица*/
$fancyTableStyle = array('borderSize' => 6, 'borderColor' => '999999');
$cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center');
$cellRowContinue = array('vMerge' => 'continue','spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>0);
$cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
$cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>0);
$cellVCentered = array('valign' => 'center');

$spanTableStyleName = 'Colspan Rowspan';
$word->addTableStyle($spanTableStyleName, $fancyTableStyle);
$table = $section->addTable($spanTableStyleName);

$table->addRow(100);

$cell1 = $table->addCell(2000, $cellRowSpan);
$textrun1 = $cell1->addTextRun($cellHCentered);
$textrun1->addText('На учебный год');

$cell2 = $table->addCell(4501, $cellColSpan);
$textrun2 = $cell2->addTextRun($cellHCentered);
$textrun2->addText("ОДОБРЕНО");
$textrun2->addTextBreak();
$textrun2->addText('На заседании кафедры');

$cell3 = $table->addCell(4500, $cellColSpan);
$textrun3 = $cell3->addTextRun($cellHCentered);
$textrun3->addText('УТВЕРЖДАЮ');
$textrun3->addTextBreak();
$textrun3->addText('Заведующий кафедрой');

$table->addRow(300);
$table->addCell(null, $cellRowContinue);
$table->addCell(1800, $cellVCentered)->addText('Протокол', null, $cellHCentered);
$table->addCell(2700, $cellVCentered)->addText('Дата', null, $cellHCentered);
$table->addCell(1800, $cellVCentered)->addText('Подпись', null, $cellHCentered);
$table->addCell(2700, $cellVCentered)->addText('Дата', null, $cellHCentered);

for ($i = 1; $i <= 4; $i++) {
    $table->addRow(100);
    $table->addCell(2000, $cellVCentered)->addText('20__ – 20__', null, $cellHCentered);
    $table->addCell(1800, $cellVCentered)->addText('№______', null, $cellHCentered);
    $table->addCell(2700, $cellVCentered)->addText('«___» _____20__г.', null, $cellHCentered);
    $table->addCell(1800, $cellVCentered);
    $table->addCell(2700, $cellVCentered)->addText('«___» _____20__г.', null, $cellHCentered);
}
$section->addText('',array(), array('spacing'=>36,'spaceBefore'=>110, 'spaceAfter'=>0, 'align'=>'center'));
$section->addText('Иркутск, '.date("Y").' г.',null, array('spacing'=>36,'spaceBefore'=>0, 'spaceAfter'=>0, 'align'=>'center'));
$section->addPageBreak();

/*МАССИВЫ СТИЛЕЙ ТЕКСТА*/
$styleHeader = array('bold'=>true);
$positionHeader = array('align'=>'left','spacing'=>60,'spaceBefore'=>60, 'spaceAfter'=>40);
$styleText = array();
$positionText = array('align'=>'both','spacing'=>0,'spaceBefore'=>0, 'spaceAfter'=>0);
$positionTextCenter = array('align'=>'center','spacing'=>0,'spaceBefore'=>0, 'spaceAfter'=>0);

/*ФОРМИРОВАНИЕ ПУНКТА 1. ПЛАНИРУЕМЫЕ РЕЗУЛЬТАТЫ */
/*Пункт 1.1 Перечень компетенций*/
$section->addText('1. Перечень планируемых результатов обучения по дисциплине', $styleHeader,$positionHeader);
$section->addText('1.1 Перечень компетенций, установленных ФГОС', $styleHeader,$positionHeader);
$section->addText('    После изучения дисциплины «'.$discpl.'» выпускник должен обладать следующими общепрофессиональными компетенциями (ОПК) и профессиональными компетенциями (ПК):',$styleText,$positionText);

for ($i = 0; $i< count($kompetentName); $i++){
    $section->addListItem($kompetentName[$i].' ('.$kompetentAbbr[$i].'-'.$kompetentNum[$i].');',0,$styleText,array(), array('listType'=>'TYPE_BULLET_FILLED'));
}
/*Пункт 1.2 Цели и задачи дисциплины*/
$section->addText('1.2 Цели и задачи освоения программы дисциплины', $styleHeader,$positionHeader);
$section->addText('    '.$celi,$styleText,$positionText);
$section->addText('',$styleText, array('spaceBefore'=>0, 'spaceAfter'=>0, 'spacing'=>36));
$zadachi = explode("\n",$zadachi);
$section->addText($zadachi[0]);
for ($i = 1; $i< count($zadachi); $i++){
    $section->addListItem($zadachi[$i],0,$styleText, $positionText);
}

/*Пункт 1.3 Результаты освоения дисциплины*/
$section->addText('1.3 Результаты освоения дисциплины', $styleHeader, $positionHeader);
$section->addText('В результате освоения дисциплины студенты должны:',$styleText, $positionText);
$section->addText('Знать:', $styleHeader, $positionHeader);

$znat = explode("\n",$znat);
for ($i = 0; $i< count($znat); $i++){
    $section->addText('    '.$znat[$i],$styleText,$positionText);
}

$section->addText('Уметь:', $styleHeader, $positionHeader);
$umet = explode("\n",$umet);
for ($i = 0; $i< count($umet); $i++){
    $section->addText('    '.$umet[$i],$styleText,$positionText);
}

$section->addText('Владеть:', $styleHeader, $positionHeader);
$vladet = explode("\n",$vladet);
for ($i = 0; $i< count($vladet); $i++) {
    $section->addText('    '.$vladet[$i], $styleText,$positionText);
}

/*2. МЕСТО ДИСЦИПЛИНЫ В УЧЕБНОМ ПЛАНЕ*/
$section->addText('2. Место дисциплины в структуре ООП', $styleHeader,$positionHeader);

if ($doo!='') {
    $section->addText('Обеспечиваемые (последующие) дисциплины и практики', $styleHeader,$positionHeader);
    $doo = explode("\n",$doo);
    for ($i = 0; $i< count($doo); $i++) {
        $section->addText('    ' . $doo[$i], $styleText, $positionText);
    }
}

if ($posle!='') {
    $section->addText('Обеспечивающие (предшествующие) дисциплины и практики', $styleHeader,$positionHeader);
    $posle = explode("\n",$posle);
    for ($i = 0; $i< count($posle); $i++) {
        $section->addText('    ' . $posle[$i], $styleText, $positionText);
    }
}


$section->addPageBreak();
/*3 СТРУКТУРА ДИСЦИПЛИНЫ*/
$sizeCell = 5000/($count_semestr+1);
$sizeCellFirst = 7000;
$cellColSpan2 = array('gridSpan' => $count_semestr+1, 'valign' => 'center');

$section->addText('3. Структура дисциплины',$styleHeader, $positionHeader);

$word->addTableStyle('', $fancyTableStyle);
$table = $section->addTable($spanTableStyleName);

//заголовок таблицы
$table->addRow(100);

$cell1 = $table->addCell($sizeCellFirst, $cellRowSpan);
$textrun1 = $cell1->addTextRun($cellHCentered);
$textrun1->addText('Вид учебной работы');

$cell2 = $table->addCell(5000, $cellColSpan2);
$textrun2 = $cell2->addTextRun($cellHCentered);
$textrun2->addText('Количество часов');

$table->addRow(100);
$table->addCell(null, $cellRowContinue);
$table->addCell($sizeCell, $cellVCentered)->addText('Всего', null, $cellHCentered);

for ($i = 1; $i <= $count_semestr; $i++){
    $table->addCell($sizeCell, $cellVCentered)->addText('Семестр №'.(string)((int)$first_semestr+$i-1), null, $cellHCentered);
};
//тело таблицы

$table->addRow(100);
$table->addCell($sizeCellFirst,$cellVCentered)->addText('Общая трудоемкость дисциплины', $styleText, $positionText);
$table->addCell($sizeCell, $cellVCentered)->addText(queryForHourAll($doc_id,0), $styleText, $positionTextCenter);
for ($i = 0; $i <= $count_semestr-1; $i++) {
    $table->addCell($sizeCell, $cellVCentered)->addText(queryForHourAll($doc_id, $first_semestr + $i), $styleText, $positionTextCenter);
};

$table->addRow(100);
$table->addCell($sizeCellFirst,$cellVCentered)->addText('Аудиторные занятия, в том числе:', $styleText, $positionText);
$table->addCell($sizeCell, $cellVCentered)->addText(queryForAuditor($doc_id,0), $styleText, $positionTextCenter);
for ($i = 0; $i <= $count_semestr-1; $i++) {
    $table->addCell($sizeCell, $cellVCentered)->addText(queryForAuditor($doc_id,$first_semestr + $i), $styleText, $positionTextCenter);
};

$table->addRow(100);
$table->addCell($sizeCellFirst,$cellVCentered)->addText('    лекции', $styleText, $positionText);
$table->addCell($sizeCell, $cellVCentered)->addText(queryForHourSum($doc_id,1), $styleText, $positionTextCenter);
for ($i = 0; $i <= $count_semestr-1; $i++) {
   $table->addCell($sizeCell, $cellVCentered)->addText(queryForHour($doc_id, $first_semestr + $i, 1), $styleText, $positionTextCenter);
};

$table->addRow(100);
$table->addCell($sizeCellFirst,$cellVCentered)->addText('    лабораторные работы', $styleText, $positionText);
$table->addCell($sizeCell, $cellVCentered)->addText(queryForHourSum($doc_id,2), $styleText, $positionTextCenter);
for ($i = 0; $i <= $count_semestr-1; $i++) {
    $table->addCell($sizeCell, $cellVCentered)->addText(queryForHour($doc_id, $first_semestr + $i, 2), $styleText, $positionTextCenter);
};

$table->addRow();
$table->addCell($sizeCellFirst,$cellVCentered)->addText('    практические/семинарские занятия', $styleText, $positionText);
$table->addCell($sizeCell, $cellVCentered)->addText(queryForHourSum($doc_id,3), $styleText, $positionTextCenter);
for ($i = 0; $i <= $count_semestr-1; $i++) {
    $table->addCell($sizeCell, $cellVCentered)->addText(queryForHour($doc_id, $first_semestr + $i, 3), $styleText, $positionTextCenter);
};

$table->addRow(100);
$table->addCell($sizeCellFirst,$cellVCentered)->addText('Самостоятельная работа (в т.ч. курсовое проектирование)', $styleText, $positionText);
$table->addCell($sizeCell, $cellVCentered)->addText(queryForHourSum($doc_id,4), $styleText, $positionTextCenter);
for ($i = 0; $i <= $count_semestr-1; $i++) {
    $table->addCell($sizeCell, $cellVCentered)->addText(queryForHour($doc_id, $first_semestr + $i, 4), $styleText, $positionTextCenter);
};

$table->addRow(100);
$table->addCell($sizeCellFirst,$cellVCentered)->addText('Трудоемкость промежуточной аттестации', $styleText, $positionText);
$table->addCell($sizeCell, $cellVCentered)->addText(queryForHourSum($doc_id,5), $styleText, $positionTextCenter);
for ($i = 0; $i <= $count_semestr-1; $i++) {
    $table->addCell($sizeCell, $cellVCentered)->addText(queryForHour($doc_id, $first_semestr + $i, 5), $styleText, $positionTextCenter);
};

$table->addRow(100);
$table->addCell($sizeCellFirst,$cellVCentered)->addText('Вид промежуточной аттестации (итогового контроля по дисциплине)', $styleText, $positionText);
$table->addCell($sizeCell, $cellVCentered)->addText(queryForFormcontrAll($doc_id), $styleText, $positionTextCenter);
for ($i = 0; $i <= $count_semestr-1; $i++) {
    $table->addCell($sizeCell, $cellVCentered)->addText(queryForFormcontr($doc_id, $first_semestr+$i), $styleText, $positionTextCenter);
};



/*СОХРАНЕНИЕ*/
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($word, 'Word2007');
$objWriter->save('doc.docx');

?>
