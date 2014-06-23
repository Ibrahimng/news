<h1>Новости</h1>
<a href="create">Добавить новость</a>
<table>
    <tr><th>ID</th><th>Название</th><th>Текст</th><th>Дата</th><th>Изображение</th></tr>
    <tbody>
    <?php

    foreach($data as $row)
    {
        echo '<tr><td>'.$row['id'].'</td><td>'.$row['a_title'].'</td><td>'.$row['a_text'].'</td><td>' . date("d.m.Y" ,strtotime($row['a_date'])) . "</td><td><img src='" . $row['a_filepath'] . "'></td></tr>";
    }

    ?>
    </tbody>
</table>
