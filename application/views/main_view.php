<h1>Новости</h1>
<a href="create">Добавить новость</a>
<table>
    Новости-хобости
    <tr><td>ID</td><td>Название</td><td>Текст</td></tr>
    <?php

    foreach($data as $row)
    {
        echo '<tr><td>'.$row['id'].'</td><td>'.$row['a_title'].'</td><td>'.$row['a_text'].'</td><td>' . $row['a_date'] . "</td><td><img src='" . $row['a_filepath'] . "'></td></tr>";
    }

    ?>
</table>
