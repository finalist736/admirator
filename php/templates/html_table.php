<?php
include 'header.php';

$buffer = '';

$th_block = <<<EOT
        <th>{field_name}</th>

EOT;

$td_block = <<<EOT
        echo '<td>'.\$row['{field_name}'].'</td>';

EOT;

$result_data = <<<EOT
<?php
include 'header.php';
?>

<p>
    <a href="/{table_name}/add" class="btn btn-primary">Добавить</a>
</p>
<table class="table table-hover table-bordered">
    <tr class="active">
        <th style="min-width: 210px;">ACTIONS</th>
{TH}
        <th style="min-width: 210px;">ACTIONS</th>
    </tr>

    <?php
    if (\$result_{table_name} && is_object(\$result_{table_name})) while (\$row = \$result_{table_name}->fetch_assoc())
    {
        echo '<tr>';
        echo '<td class="active">
<a class="btn btn-success" href="/{table_name}/copy/'.\$row['ID'].'">copy</a>
<a class="btn btn-warning" href="/{table_name}/edit/'.\$row['ID'].'">edit</a>
<a class="btn btn-danger btn-remove" href="/{table_name}/remove/'.\$row['ID'].'">remove</a>
</td>';
{TD}
        echo '<td class="active">
<a class="btn btn-success" href="/{table_name}/copy/'.\$row['ID'].'">copy</a>
<a class="btn btn-warning" href="/{table_name}/edit/'.\$row['ID'].'">edit</a>
<a class="btn btn-danger btn-remove" href="/{table_name}/remove/'.\$row['ID'].'">remove</a>
</td>';
        echo '</tr>';
    }
    ?>
</table>
<?php
include 'footer.php';
?>
<script type="application/javascript">
    $(function(){
        $(".btn-remove").click(function(){
            return confirm("Are you sure??");
        });
    });
</script>
EOT;

$Table = filter_input(INPUT_POST, 'Table', FILTER_SANITIZE_STRING);

$q = sprintf('SHOW FULL COLUMNS FROM `%s`', $Table);

if ($result_columns = $_mysqli->query($q))
{
    $th = '';
    $td = '';

    while ($row = $result_columns->fetch_row())
    {
        $name = $row[0];
        $type = $row[1];
        $copy_array_tmp .= str_replace('{field_name}', $name, $copy_array);

        $th .= str_replace('{field_name}', $name, $th_block);
        $td .= str_replace('{field_name}', $name, $td_block);
    }
    $result_data = str_replace('{TH}', $th, $result_data);
    $result_data = str_replace('{TD}', $td, $result_data);
    $result_data = str_replace('{table_name}', $Table, $result_data);
    $buffer = $result_data;
}
?>
<textarea rows="44" cols="250"><?=$buffer?></textarea>
<?php
include 'footer.php';
?>
