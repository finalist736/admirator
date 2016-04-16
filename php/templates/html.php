<?php
include 'header.php';
?>
<h3>Таблица</h3>
<form action="/html" method="post" class="form-horizontal">
    <div class="form-group">
        <label for="Table" class="col-sm-2 control-label">Table</label>
        <div class="col-sm-4">
            <select name="Table" class="form-control" id="Table">
                <?php
                if ($result_tables && is_object($result_tables)) while ($row = $result_tables->fetch_row())
                {
                    echo '<option value="' . $row[0] . '">' . $row[0] . '</option>';
                }
                ?>
            </select>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <button type="submit" class="btn btn-success" name="form">Form</button>
            <button type="submit" class="btn btn-success" name="table">Table</button>
        </div>
    </div>
</form>
<?php
include 'footer.php';
?>
