<?php require_once('./includes/header.php'); ?>
<?php

?>
<div class="container">
    <form id="upload_csv" method="post" enctype="multipart/form-data">
        <div class="col-md-3">
            <label>Select CSV File</label>
        </div>
        <div class="col-md-4">
            <input type="file" name="csv_file" id="csv_file" accept=".csv" />
        </div>
        <div class="col-md-5">
            <input type="submit" name="upload" id="upload" value="Upload" class="btn btn-primary" />
        </div>
    </form>

    <div id="csv_file_data">f</div>
</div>
<?php require_once('./includes/footer.php'); ?>