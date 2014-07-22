<div id="content">
<h1>Добавьте тэг</h1>
<form id="new-tag-form" name="new-tag" action="/tag/create" method="post">
    <table>
        <tr><td align="right"><label>Название тэга:</label></td><td><input maxlength="15" id="tname" type="text" name="t-name"></td></tr>

        <tr><td></td><td><input type="submit" name="add" value="Добавить"></td></tr>
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
        $('#tname').each(function() {
            var cur_length = $(this).val().trim().length;
            if(cur_length > 15 || cur_length < 3) {
                event.preventDefault();
                $(this).css('border', '2px solid orangered');
                $('div.error').append("В названии тэга должно быть не менее 3-х симоволов и не более 15<br>");
            }
            else
                $(this).css('border', '');
        });

    });
</script>
