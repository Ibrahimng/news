
<!DOCTYPE html>
<html lang="ru">
<head>
    <link rel="stylesheet" type="text/css" href="/css/style.css" />
<!--    <script src="/js/jquery-1.11.1.js" type="text/javascript"></script>-->
<!--    <script src="/js/jquery-ui-1.10.4.js" type="text/javascript"></script>-->
    <!-- 1. Подключим библиотеку jQuery (без нее jQuery UI не будет работать) -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <!-- 2. Подключим jQuery UI -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
    <meta charset="utf-8">
    <title>Главная</title>
</head>
<body>
    <div id="header">
        <a class="button-link" href="/"><div class="menu-item">Новости</div></a>
        <a class="button-link" href="<?php $_SERVER['SERVER_NAME'];?>/tag"><div class="menu-item">Тэги</div></a>
    </div>
    <?php include 'application/views/'.$content_view; ?>
    <div id="space"></div>
    <div id="footer">
        <p>
            &copy 2014 Maxibello
        </p>
    </div>
</body>
</html>