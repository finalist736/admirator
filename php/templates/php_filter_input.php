<?php
include 'header.php';

$buffer = '';

$Table = filter_input(INPUT_POST, 'Table', FILTER_SANITIZE_STRING);

$q = sprintf('SHOW COLUMNS FROM `%s`', $Table);
$query_insert = sprintf('$q = \'INSERT INTO `%s`({FIELDS}) VALUES({VALUES})\';', $Table);
$query_update = sprintf('$q = \'UPDATE `%s` SET ', $Table);

$shmt = 'if ($shmt = $_mysqli->prepare($q)){
            $shmt->bind_param(\'{SHMT_ISD}\', {SHMT_VARS});
            $shmt->execute();
        }';

if ($result_columns = $_mysqli->query($q))
{
    $query_insert_tmp_fields = '';
    $query_insert_tmp_values = '';

    $query_update_tmp = '';

    $shmt_tmp_isd = '';
    $shmt_tmp_vars = '';

    while ($row = $result_columns->fetch_row())
    {
        $name = $row[0];
        $type = $row[1];
        $shmt_type = '';
        if(strpos($type, 'float') !== false)
        {
            $type = 'FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION';
            $shmt_type = 'd';
        }
        else if (strpos($type, 'int') !== false)
        {
            $type = 'FILTER_SANITIZE_NUMBER_INT';
            $shmt_type = 'i';
        }
        else if (strpos($type, 'enum') !== false)
        {
            $type = 'FILTER_SANITIZE_STRING';
            $shmt_type = 's';
        }
        else if (strpos($type, 'varchar') !== false)
        {
            $type = 'FILTER_SANITIZE_STRING';
            $shmt_type = 's';
        }
        else
        {
            $type = 'FILTER_SANITIZE_STRING';
            $shmt_type = 's';
        }
        $buffer .= "\${$name} = filter_input(INPUT_POST, '{$name}', {$type});\r\n";
        if ($name != 'ID')
        {
            $query_insert_tmp_fields .= "`{$name}`,";
            $query_insert_tmp_values .= '?,';
            $query_update_tmp .= "`{$name}`=?, ";

            $shmt_tmp_isd .= $shmt_type;
            $shmt_tmp_vars .= "\${$name}, ";
        }
    }

    $query_insert_tmp_fields = substr($query_insert_tmp_fields, 0, -1);
    $query_insert_tmp_values = substr($query_insert_tmp_values, 0, -1);
    $query_update_tmp = substr($query_update_tmp, 0, -2);
    $shmt_tmp_vars = substr($shmt_tmp_vars, 0, -2);

    $query_insert = str_replace('{FIELDS}', $query_insert_tmp_fields, $query_insert);
    $query_insert = str_replace('{VALUES}', $query_insert_tmp_values, $query_insert);
    $query_update = $query_update . $query_update_tmp . ' WHERE `ID`=?\';';

    $shmt_insert = str_replace('{SHMT_ISD}', $shmt_tmp_isd, $shmt);
    $shmt_insert = str_replace('{SHMT_VARS}', $shmt_tmp_vars, $shmt_insert);

    $shmt_tmp_isd .= 'i';
    $shmt_tmp_vars .= ', $ID';
    $shmt_update = str_replace('{SHMT_ISD}', $shmt_tmp_isd, $shmt);
    $shmt_update = str_replace('{SHMT_VARS}', $shmt_tmp_vars, $shmt_update);


    $buffer .= "\r\n\r\n{$query_insert}";
    $buffer .= "\r\n{$shmt_insert}";
    $buffer .= "\r\n\r\n{$query_update}";
    $buffer .= "\r\n{$shmt_update}";
}
?>
<textarea rows="44" cols="250"><?=$buffer?></textarea>
<?php
include 'footer.php';
?>
