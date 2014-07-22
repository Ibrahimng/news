<div id="content">
<h1>Редактирование тэга</h1>
<form id="new-tag-form" name="edit-tag" action="/tag/edit" method="post">
    <table id="add-tag">
        <tr><td align="right"><label>Название тэга:</label></td><td><input maxlength="15" id="tname" type="text" name="t-name" value='<?php echo $data['tag']['t_name'];?>'></td></tr>

        <tr><td></td><td><input type="submit" name="save" value="Сохранить"></td></tr>
        <input type="hidden" name="t-id" value="<?php echo $data['tag']['id'];?>">
    </table>
</form>
<div class="error">
    <?php if(isset($data['errors'])){
        foreach($data['errors'] as $msg)
            echo $msg."<br>";
    } ?>
</div>
</div>
<script>

    $('#new-tag-form').bind('submit', function(event) {
        $('div.error').text("");
        var cur_length = $('#tname').val().trim().length;
        if(cur_length > 15 || cur_length < 3) {
            event.preventDefault();
            $('#atitle').css('border', '2px solid orangered');
            $('div.error').append("В названии новости должно быть не менее 3-х симоволов и не более 50<br>");
        }
        else
            $('#tname').css('border', '');
    });
</script>
