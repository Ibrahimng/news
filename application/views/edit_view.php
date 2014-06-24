
<h1>Добавьте новость по вкусу</h1>
<form id="new-article-form" name="new-article" enctype="multipart/form-data" action="create" method="post">
    <table id="add-article">
        <tr><td align="right"><label>Дата:</label></td><td><input id="adate" class="datepicker" type="text" name="a-date" value='<?php echo $data['a_date']; ?>'></td></tr>
        <tr><td align="right"><label>Заголовок:</label></td><td><input size="65" id="atitle" type="text" name="a-title"></td></tr>
        <tr><td align="right"><label>Фотография:</label></td><td><input type="file" name="a-file"></td></tr>
        <tr><td align="right" valign="top"><label>Текст:</label></td><td><textarea id="atext" name="a-text" cols="50" rows="10"></textarea></td></tr>
        <tr><td></td><td><input type="submit" name="add" value="Добавить"></td></tr>
    </table>
</form>
<div class="error">
    <?php if(isset($data)){
        foreach($data as $msg)
            echo $msg."<br>";
    } ?>
</div>
<script>
    $(document).ready(function() {
        $.datepicker.regional['ru'] = {
            showButtonPanel: true,
            changeYear: true,
            changeMonth: true,
            showAnim: 'bounce',
            closeText: 'Закрыть',
            prevText: '&#x3c;Пред',
            nextText: 'След&#x3e;',
            currentText: 'Сегодня',
            monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
                'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
            monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
                'Июл','Авг','Сен','Окт','Ноя','Дек'],
            dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
            dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
            dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
            dateFormat: 'dd.mm.yy',
            firstDay: 1,
            isRTL: false
        };
        $.datepicker.setDefaults($.datepicker.regional['ru']);
        $('input.datepicker').datepicker();
        $('input.datepicker').datepicker(
            "option", "showAnim", "clip"
        );
    });

    $('#new-article-form').bind('submit', function(event) {
        $('div.error').text("");
        $('#atitle').each(function() {
            var cur_length = $(this).val().trim().length;
            if(cur_length > 50 || cur_length < 3) {
                event.preventDefault();
                $(this).css('border', '2px solid orangered');
                $('div.error').append("В названии новости должно быть не менее 3-х симоволов и не более 50<br>");
            }
            else
                $(this).css('border', '');
        });
        $('#atext').each(function() {
            var cur_length = $(this).val().trim().length;
            if(cur_length > 140 || cur_length < 10) {
                event.preventDefault();
                $(this).css('border', '2px solid orangered');
                $('div.error').append("В тексте новости должно быть не менее 10 симоволов и не более 140<br>");
            }
            else
                $(this).css('border', '');
        });

        $('#adate').each(function(){
            var txtVal =  $('#adate').val();
            if(!isDate(txtVal)) {
                $(this).css('border', '2px solid orangered');
                $('div.error').append("Дата должна быть в формате дд.мм.ГГГГ<br>");
            }
            else {
                $(this).css('border', '');
            }
        });
    });

    function isDate(txtDate)
    {
        var currVal = txtDate;
        if(currVal == '')
            return false;

        //Declare Regex
        var rxDatePattern = /^(\d{1,2})(\/|.)(\d{1,2})(\/|.)(\d{4})$/;
        var dtArray = currVal.match(rxDatePattern); // is format OK?

        if (dtArray == null)
            return false;

        //Checks for mm/dd/yyyy format.
        dtMonth = dtArray[3];
        dtDay= dtArray[1];
        dtYear = dtArray[5];

        if (dtMonth < 1 || dtMonth > 12)
            return false;
        else if (dtDay < 1 || dtDay> 31)
            return false;
        else if ((dtMonth==4 || dtMonth==6 || dtMonth==9 || dtMonth==11) && dtDay ==31)
            return false;
        else if (dtMonth == 2)
        {
            var isleap = (dtYear % 4 == 0 && (dtYear % 100 != 0 || dtYear % 400 == 0));
            if (dtDay> 29 || (dtDay ==29 && !isleap))
                return false;
        }
        return true;
    }
</script>
