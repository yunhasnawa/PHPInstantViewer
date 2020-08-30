<html>
<head>
    <title>PHPInstantViewer</title>
    <link rel=stylesheet href="piv/assets/style.css" type="text/css">
</head>
<body>
<h2><?php echo ucwords(str_replace('_', ' ', $table_name)); ?> Data Viewer</h2>
<p>
    Filter <?php echo $table_name; ?> by:
</p>
<form method="post">
    <select name="filter_field" id="filter_field">
        <option value="">-- No Filter --</option>
        <?php foreach ($column_names as $index => $column_name) {?>
            <option value="<?php echo $column_name; ?>"><?php echo $pretty_column_names[$index]; ?></option>
        <?php } ?>
    </select>
    <input type="text" id="filter_text" name="filter_text" >
    <input type="submit" name="submit" value="Submit">
</form>
<hr />
<table class="data-table">
    <thead>
        <?php foreach ($pretty_column_names as $column_name) { ?>
            <th class="data-table-th"><?php echo $column_name; ?></th>
        <?php } ?>
    </thead>
    <tbody>
    <?php if($records == null) { ?>
        <tr class="data-table-tr">
            <td class="data-table-td" colspan="<?php echo count($pretty_column_names); ?>">No records to show. Please click Submit button or try another filter.</td>
        </tr>
    <?php } else { ?>
        <?php foreach ($records as $row) {?>
            <tr class="data-table-tr">
                <?php foreach ($row as $col => $value) { ?>
                    <td class="data-table-td"><?php echo $value; ?></td>
                <?php } ?>
            </tr>
        <?php } ?>
    <?php }?>
    </tbody>
</table>
</body>
</html>