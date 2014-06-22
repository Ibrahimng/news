
<h1>Добавьте новость по вкусу</h1>
<form name="new-article" enctype="multipart/form-data" action="create" method="post">
    Дата:<input class="datepicker" type="text" name="a-date"><br>
    Заголовок:<input type="text" name="a-title"><br>
    Текст:<textarea name="a-text" cols="30" rows="10"></textarea><br>
<!--    <input type="hidden" name="MAX_FILE_SIZE" value="2048" />-->
    Фотография:<input type="file" name="a-file">
    <input type="submit" name="add" value="Добавить">
</form>
<?php echo $data; ?>
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
</script>
