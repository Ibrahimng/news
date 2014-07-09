<script>
    function confirmDelete() {
        if (confirm("Вы уверены, что хотите удалить её к херам?")) {
            return true;
        } else {
            return false;
        }
    }
</script>
<h1><a href="/">Новости</a></h1>
<a href="article/create">Добавить новость</a>

<div class="korpus">
    <input type="radio" name="odin" checked="checked" id="vkl1"/><a href="/main/index"><label for="vkl1">Актуальные</label></a><input type="radio" name="odin" id="vkl2"/><a href="/main/indexh"><label for="vkl2">Скрытые</label></a>
    <div>
        <table class="news-list">
            <tr><th>ID</th><th>Название</th><th>Текст</th><th>Дата</th><th>Изображение</th><th>Теги</th></tr>
            <tbody>
            <?php


                foreach($data as $row)
                {
                    if ($row['a_hidden'] == 0) {
                        $tags = "";
                        foreach ($row['tags'] as $t_key => $t_value) {
                            $tags .= "<a href='/main/tag/?tag=" . $t_value['t_id'] . "'>" . $t_value['t_name'] . "</a><br>";
                        }

                        echo '<tr><td>'. $row['id'] .'</td><td>'.$row['a_title'].'</td><td>'.$row['a_text'].'</td><td>' . date("d.m.Y" ,strtotime($row['a_date'])) . "</td><td><img src='/upload/" . $row['a_filepath'] . "'></td><td>".  $tags."</td><td><a href='/article/edit/?id=" . $row['id'] . "'>Изменить</a></td><td><a onclick='return confirmDelete();' href='/article/delete/?id=" . $row['id'] . "'>Удалить</a></td></tr>";

                    }

                }

            ?>
            </tbody>
        </table>
    </div>
    <div>

        <table class="news-list">
            <tr><th>ID</th><th>Название</th><th>Текст</th><th>Дата</th><th>Изображение</th></tr>
            <tbody>
            <?php

                foreach($data as $row)
                {
                    if ($row['a_hidden'] == 1) {
                        $tags = "";
                        foreach ($row['tags'] as $t_key => $t_value) {
                            $tags .= "<a href='/main/tag/?tag=" . $t_value['t_id'] . "'>" . $t_value['t_name'] . "</a><br>";
                        }

                        echo '<tr><td>'. $row['id'] .'</td><td>'.$row['a_title'].'</td><td>'.$row['a_text'].'</td><td>' . date("d.m.Y" ,strtotime($row['a_date'])) . "</td><td><img src='/upload/" . $row['a_filepath'] . "'></td><td>".  $tags."</td><td><a href='/article/edit/?id=" . $row['id'] . "'>Изменить</a></td><td><a onclick='return confirmDelete();' href='/article/delete/?id=" . $row['id'] . "'>Удалить</a></td></tr>";

                    }

                }

            ?>
            </tbody>
        </table>

    </div>
</div>
<script>
    function confirmDelete() {
        if (confirm("Вы уверены, что хотите удалить её к херам?")) {
            return true;
        } else {
            return false;
        }
    }
</script>


