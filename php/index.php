<?php

/**
 * TODO
 * AUTHORISATION
 *
 */
$current_user_id = 1;

error_reporting(E_ALL ^ E_NOTICE);
header('Content-Type: text/html; charset=utf-8');

include 'config.php';
include 'tools.php';
include 'db.php';

$controller = 'index';
$action = array();
$template = 'index';

if (isset($_GET['path']))
{
    $path = explode('/', $_GET['path']);
    if (count($path) > 1)
    {
        $controller = array_shift($path);
        $action = $path;
    }
    else if (count($path) == 1)
    {
        $controller = $path[0];
    }
}
$controller_path = '.' . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR . $controller . '.php';
if (file_exists($controller_path))
{
    include $controller_path;
    $template_path = 'templates' . DIRECTORY_SEPARATOR . $template . '.php';
    if (file_exists($template_path))
    {
        include $template_path;
    }
}

$_mysqli->close();

