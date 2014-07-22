<div id="content">

    <a class="button-link" href="/"><div class="filter">Актуальные</div></a>
    <a class="button-link" href="/main/index/?active=0"><div class="filter">Скрытые</div></a>
    <a class="button-link" href="<?php $_SERVER['SERVER_NAME'];?>/article/create"><div class="add-new">Добавить новость</div></a>
    <div>
        <table class="news-list">
            <tr><th>ID</th><th>Название</th><th>Текст</th><th>Дата</th><th>Изображение</th><th>Теги</th></tr>
            <tbody>
            <?php

                foreach($data['articles'] as $row)
                {
                        $hidden = $row['a_hidden'];
                        $tags = "";

                        if (isset($row['tags']))
                        {
                            foreach ($row['tags'] as $t_key => $t_value) {
                                $active = 1;
                                if ($hidden == '1')
                                    $active = 0;
                                if ($active)
                                    $tags .= "<a href='/main/index/?type=tag&tag=" . $t_value['t_id'] . "'>" . $t_value['t_name'] . "</a><br>";
                                else
                                    $tags .= "<a href='/main/index/?type=tag&active=0&tag=" . $t_value['t_id'] . "'>" . $t_value['t_name'] . "</a><br>";
                            }
                        }


                        echo '<tr><td>'. $row['id'] .'</td><td>'.$row['a_title'].'</td><td>'.$row['a_text'].'</td><td>' . date("d.m.Y" ,strtotime($row['a_date'])) . "</td><td><img src='" . (($row['a_filepath'] == '') ? '/default-image.gif' : ('/upload/' . $row['a_filepath']) ) . "'></td><td>".  $tags."</td><td><a href='/article/edit/?id=" . $row['id'] . "'>Изменить</a></td><td><a onclick='return confirmDelete();' href='/article/delete/?id=" . $row['id'] . "'>Удалить</a></td></tr>";



                }


            ?>
            </tbody>
        </table>
        <?php
            if ($data['pageCount'] > 1)
            {
                echo "<ul class='paging'>";
                for ($i = 0; $i < $data['pageCount']; $i++)
                {
                    $li = "<li><a class='a-paging' href='/main/index/?";
                    if (!$data['active'])
                        $li .= "active=0&";
                    if ($data['type'] == 'tag')
                        $li .= "type=tag&";
                    if (isset($data['tag']) && $data['tag'] != '')
                        $li .= "tag=" . $data['tag'] . "&";
                    $li .= "page=" . ($i + 1) . "'>" . ($i + 1) . "</a>";
                    echo $li;
                }
                echo "</ul>";
            }

        ?>
    </div>
</div>
<script>
    function confirmDelete() {
        if (confirm("Вы уверены, что хотите удалить эту новость?")) {
            return true;
        } else {
            return false;
        }
    }
</script>


