<div id="content">
<div>
    <a href="/">Актуальные</a><a href="/main/index/?active=0">Скрытые</a>
    <div>
        <table class="news-list">
            <tr><th>ID</th><th>Название</th><th>Текст</th><th>Дата</th><th>Изображение</th><th>Теги</th></tr>
            <tbody>
            <?php


                foreach($data as $row)
                {
                        $hidden = $row['a_hidden'];
                        $tags = "";
                        foreach ($row['tags'] as $t_key => $t_value) {
                            $active = 1;
                            if ($hidden == '1')
                                $active = 0;
                            if ($active)
                                $tags .= "<a href='/main/index/?type=tag&tag=" . $t_value['t_id'] . "'>" . $t_value['t_name'] . "</a><br>";
                            else
                                $tags .= "<a href='/main/index/?type=tag&active=0&tag=" . $t_value['t_id'] . "'>" . $t_value['t_name'] . "</a><br>";
                        }

                        echo '<tr><td>'. $row['id'] .'</td><td>'.$row['a_title'].'</td><td>'.$row['a_text'].'</td><td>' . date("d.m.Y" ,strtotime($row['a_date'])) . "</td><td><img src='/upload/" . $row['a_filepath'] . "'></td><td>".  $tags."</td><td><a href='/article/edit/?id=" . $row['id'] . "'>Изменить</a></td><td><a onclick='return confirmDelete();' href='/article/delete/?id=" . $row['id'] . "'>Удалить</a></td></tr>";



                }

            ?>
            </tbody>
        </table>
    </div>
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


