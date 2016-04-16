<?php

$result_tables = null;

if (count($_POST) > 0)
{
    if (isset($_POST['filter_input']))
    {
        $template = 'php_filter_input';
    }
    if (isset($_POST['file']))
    {
        $template = 'php_file';
    }
}
else
{
    $q = 'SHOW TABLES';
    $result_tables = $_mysqli->query($q);
    $template = 'php';
}
