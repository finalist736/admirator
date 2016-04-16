<?php
$result_tables = null;

if (count($_POST) > 0)
{
    if (isset($_POST['form']))
    {
        $template = 'html_form';
    }
    if (isset($_POST['table']))
    {
        $template = 'html_table';
    }
}
else
{
    $q = 'SHOW TABLES';
    $result_tables = $_mysqli->query($q);
    $template = 'html';
}
