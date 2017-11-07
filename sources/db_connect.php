<?php
// Соединение, выбор базы данных
//phpinfo();
$dbconn = pg_connect("host=localhost port=5432 dbname=lena user=postgres password=89247108625")
or die('Could not connect: ' . pg_last_error());
/*
// Выполнение SQL запроса
$query = 'SELECT * FROM catfaculty where name like \'%д%\'';
$result = pg_query($query) or die('Ошибка запроса: ' . pg_last_error());

// Вывод результатов в HTML
echo "<table>\n";
while ($line = pg_fetch_array($result, null, PGSQL_ASSOC)) {
echo "\t<tr>\n";
    foreach ($line as $col_value) {
        echo "\t\t<td>$col_value</td>\n";
    }
    echo "\t</tr>\n";
}
echo "</table>\n";

// Очистка результата
pg_free_result($result);

// Закрытие соединения
pg_close($dbconn);*/
?>