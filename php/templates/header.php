<?php
$_current_menu_span = '  class="active"';
$menu_current_index = '';
$menu_current_qt = '';
$menu_current_php = '';
$menu_current_html = '';
switch ($template)
{
    case 'index':
        $menu_current_index = $_current_menu_span;
        break;
    case 'qt':
        $menu_current_qt = $_current_menu_span;
        break;
    case 'php':
    case 'php_filter_input':
    case 'php_file':
        $menu_current_php = $_current_menu_span;
        break;
    case 'html':
    case 'html_form':
    case 'html_table':
        $menu_current_html = $_current_menu_span;
        break;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <title><?=$title;?></title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div>
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Flint Objects tool</a>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li<?=$menu_current_index?>><a href="/index">Главная</a></li>
                    <li<?=$menu_current_qt?>><a href="/qt">Qt Object</a></li>
                    <li<?=$menu_current_php?>><a href="/php">PHP</a></li>
                    <li<?=$menu_current_html?>><a href="/html">HTML</a></li>
                </ul>
            </div>
        </div>
    </nav>
