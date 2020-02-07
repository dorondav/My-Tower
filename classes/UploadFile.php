<?php
class UploadFile
{
    public function uploadCsv()
    {
        if (isset($_POST['upload'])) {
            $target_dir = 'uploads/';
            $target_file = $target_dir . basename($_FILES['csv_file']['name']);

            $imagEFileType = pathinfo($target_file, PATHINFO_EXTENSION);

            $uploadOk = 1;
            if ($imagEFileType != "csv") {
                $uploadOk = 0;
            }

            if ($uploadOk != 0) {
                if (move_uploaded_file($_FILES["csv_file"]["tmp_name"], $target_dir . 'csv_file.csv')) {

                    // Checking file exists or not
                    $target_file = $target_dir . 'csv_file.csv';
                    $fileexists = 0;
                    if (file_exists($target_file)) {
                        $fileexists = 1;
                    }
                    if ($fileexists == 1) {

                        // Reading file
                        $file = fopen($target_file, "r");
                        $i = 0;

                        $importData_arr = array();

                        while (($data = fgetcsv($file, 1000, ",")) !== FALSE) {
                            $num = count($data);

                            for ($c = 0; $c < $num; $c++) {
                                $importData_arr[$i][] = $data[$c];
                            }
                            $i++;
                        }
                        fclose($file);
                        print_r($importData_arr);
                        // $skip = 0;
                    }
                }
            }
        }
    }
}