<?php
//  Upload CSV FILE 
$csv = new UploadFile();
$csv->uploadCsv();
?>
<div class="card">
    <div class="card-body">
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
    </div>
</div>