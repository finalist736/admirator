<?php
global $_config;
$_mysqli = new mysqli($_config['host'], $_config['user'], $_config['pass'], $_config['name']);
if ($_mysqli->errno)
{
    echo 'db connection error';exit;
}
