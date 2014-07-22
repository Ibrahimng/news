<div id="content">
        <a class="button-link" href="<?php $_SERVER['SERVER_NAME'];?>/tag/create"><div class="add-new">Добавить тэг</div>  </a>
        <div>
            <table class="news-list">
                <tr><th>ID</th><th>Название</th></tr>
                <tbody>
                <?php

                    foreach($data['tags'] as $row)
                    {

                        echo '<tr><td>'. $row['id'] .'</td><td>'.$row['t_name'].'</td>' . "<td><a href='/tag/edit/?id=" . $row['id'] . "'>Изменить</a></td><td><a onclick='return confirmDelete();' href='/tag/delete/?id=" . $row['id'] . "'>Удалить</a></td></tr>";

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
                        $li = "<li><a class='a-paging' href='/tag/index/?";
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
        if (confirm("Вы уверены, что хотите удалить этот тэг?")) {
            return true;
        } else {
            return false;
        }
    }
</script>


