<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Викторины</title>

    <link href="/include/css/bootstrap.min.css" rel="stylesheet">
    <link href="/include/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="/include/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="/include/css/aquiz.css">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">Викторины</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">

            <ul class="nav navbar-nav navbar-right">
                <li><a href="/">Главная</a></li>
                <li class="active"><a href="/admin.php">Управление</a></li>
            </ul>

        </div><!--/.nav-collapse -->
    </div>
</nav>

<div class="container">


    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <div class="alert alert-warning" role="alert">
                <b>НЕ БОЙТЕСЬ ТЕСТИРОВАТЬ!</b> Удаляйте и добавляйте вопросы и викторины.
            </div>
        </div>

    </div>


    <div class="row">

        <div class="col-md-8 col-md-offset-2">
            <?php echo $content; ?>
        </div>

    </div>

</div> <!-- /container -->


<script src="/include/js/jquery-2.2.4.min.js"></script>
<script src="/include/js/bootstrap.min.js"></script>
<script src="/include/js/ie10-viewport-bug-workaround.js"></script>
<script src="/include/js/aquiz.js"></script>
</body>
</html>
