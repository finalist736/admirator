<?php
include 'header.php';

$buffer = '';

$string_block = <<<EOT
    <div class="form-group">
        <label for="{field_name}" class="col-sm-2 control-label">{field_name}</label>
        <div class="col-sm-4">
            <input id="{field_name}" type="text" name="{field_name}" class="form-control" placeholder="{field_name}" value="<?=\$copy['{field_name}']?>" />
        </div>
    </div>

EOT;

$enum_block = <<<EOT
    <div class="form-group">
        <label for="{field_name}" class="col-sm-2 control-label">{field_name}</label>
        <div class="col-sm-4">
            <select class="form-control" id="{field_name}" name="{field_name}">
                <?php
                \$items = get_enum_values('{table_name}', '{field_name}');
                foreach (\$items as \$item) {
                    if (\$item == \$copy['{field_name}']) \$selected = ' selected="selected"';
                    else \$selected = '';
                    echo '<option value="' . \$item . '"'.\$selected.'>' . \$item . '</option>';
                }
                ?>
            </select>
        </div>
    </div>

EOT;

$result_block = <<<EOT
    <div class="form-group">
        <label for="{field_name}" class="col-sm-2 control-label">{field_name}</label>
        <div class="col-sm-4">
            <select name="{field_name}" class="form-control" id="{field_name}">
                <option value="0">None</option>
                <?php
                if (\$result_{field_name} && is_object(\$result_{field_name}))
                    while (\$row = \$result_{field_name}->fetch_row())
                    {
                        if (\$row[0] == \$copy['{field_name}']) \$selected = ' selected="selected"';
                        else \$selected = '';
                        echo '<option value="' . \$row[0] . '"'.\$selected.'>' . \$row[1] . '</option>';
                    }
                ?>
            </select>
        </div>
    </div>

EOT;

$copy_array = <<<EOT
    \$copy['{field_name}'] = '';

EOT;


$result_data = <<<EOT
<?php
include 'header.php';
if (!isset(\$copy) || !is_array(\$copy) || count(\$copy) == 0)
{
    \$copy = array();
{COPY_ARRAY}
}
?>
<h3>{table_name}</h3>
<form action="/{table_name}/edit" method="post" class="form-horizontal">
{form_fields}
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <input type="hidden" name="ID" value="<?=\$copy['ID']?>">
            <button type="submit" class="btn btn-success" name="{table_name}">Сохранить</button>
            <button type="button" class="btn btn-danger" onclick="javascript:history.back();">Отмена</button>
        </div>
    </div>
</form>
<?php
include 'footer.php';
?>
<script type="application/javascript">
    $(function(){

    });
</script>

EOT;


$Table = filter_input(INPUT_POST, 'Table', FILTER_SANITIZE_STRING);

$q = sprintf('SHOW FULL COLUMNS FROM `%s`', $Table);

if ($result_columns = $_mysqli->query($q))
{

    $form_fields = '';
    $copy_array_tmp = '';

    while ($row = $result_columns->fetch_row())
    {
        $name = $row[0];
        $type = $row[1];
        $foreign = $row[8];
        $copy_array_tmp .= str_replace('{field_name}', $name, $copy_array);
        if ($name == 'ID')
        {
            continue;
        }
        if ($foreign == 'foreign')
        {
            $form_fields .= str_replace('{field_name}', $name, $result_block);
        }
        else if (strpos($type, 'enum') !== false)
        {
            $form_fields .= str_replace('{field_name}', $name, $enum_block);
        }
        else
        {
            $form_fields .= str_replace('{field_name}', $name, $string_block);
        }
    }
    $result_data = str_replace('{COPY_ARRAY}', $copy_array_tmp, $result_data);
    $result_data = str_replace('{form_fields}', $form_fields, $result_data);
    $result_data = str_replace('{table_name}', $Table, $result_data);
    $buffer = $result_data;
}
?>
<textarea rows="44" cols="250"><?=$buffer?></textarea>
<?php
include 'footer.php';
?>
