<script>
    function confirmDelete() {
        if (confirm("Вы уверены, что хотите удалить её к херам?")) {
            return true;
        } else {
            return false;
        }
    }
</script>
<h1>Новости</h1>
<a href="create">Добавить новость</a>

<div class="korpus">
    <input type="radio" name="odin" checked="checked" id="vkl1"/><label for="vkl1">Актуальные</label><input type="radio" name="odin" id="vkl2"/><label for="vkl2">Скрытые</label>
    <div>
        <table class="news-list">
            <tr><th>ID</th><th>Название</th><th>Текст</th><th>Дата</th><th>Изображение</th><th>Теги</th></tr>
            <tbody>
            <?php
                echo "<pre>";
                var_dump($data['visible']);
                die();
                $data['visible'] = array_unique($data['visible']);

                foreach($data['visible'] as $row)
                {
                    $tags = "";
                    foreach ($data['tags'][$row['id']] as $t_key => $t_value) {
                        $tags .= "<a href='" . $t_value['t_id'] . "'>" . $t_value['t_name'] . "</a><br>";
                    }

                    echo '<tr><td>'. $row['id'] .'</td><td>'.$row['a_title'].'</td><td>'.$row['a_text'].'</td><td>' . date("d.m.Y" ,strtotime($row['a_date'])) . "</td><td><img src='/upload/" . $row['a_filepath'] . "'></td><td>".  $tags."</td><td><a href='/edit/index/?id=" . $row['id'] . "'>Изменить</a></td><td><a onclick='return confirmDelete();' href='/delete/index/?id=" . $row['id'] . "'>Удалить</a></td></tr>";
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

                foreach($data['hidden'] as $row)
                {
                    echo '<tr><td>'. $row['id'] .'</td><td>'.$row['a_title'].'</td><td>'.$row['a_text'].'</td><td>' . date("d.m.Y" ,strtotime($row['a_date'])) . "</td><td><img src='/upload/" . $row['a_filepath'] . "'></td><td><a href='/edit/index/?id=" . $row['id'] . "'>Изменить</a></td><td><a onclick='return confirmDelete();' href='/delete/index/?id=" . $row['id'] . "'>Удалить</a></td></tr>";
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


