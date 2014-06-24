<h1>Новости</h1>
<a href="create">Добавить новость</a>
<table id="news-list">
    <tr><th>ID</th><th>Название</th><th>Текст</th><th>Дата</th><th>Изображение</th></tr>
    <tbody>
    <?php

    foreach($data as $row)
    {
        echo '<tr><td>'. $row['id'] .'</td><td>'.$row['a_title'].'</td><td>'.$row['a_text'].'</td><td>' . date("d.m.Y" ,strtotime($row['a_date'])) . "</td><td><img src='" . $row['a_filepath'] . "'></td><td><form action='edit' method='get'><button name='id' value='". $row['id'] . "' type='submit'>Изменить</button></form></td></tr>";
    }

    ?>
    </tbody>
</table>
