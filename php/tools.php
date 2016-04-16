<?php

function vd($var)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    exit;
}

function headloc($path = '/')
{
    header('Location: ' . $path);
    exit;
}
