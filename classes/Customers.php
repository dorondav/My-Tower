<?php
class Customers
{
    private  $_db = null;
    public function __construct()
    {
        $this->_db = DB::getInstance();
    }
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

                        try {
                            $skip = 0;
                            foreach ($importData_arr as $data) {
                                if ($skip != 0) {
                                    $customer_id = $data[0];
                                    $date = $data[1];
                                    $call_duration = $data[2];
                                    $dialed_phone_number = $data[3];
                                    $customer_ip = $data[4];

                                    // Checking duplicate entry
                                    // $query = ("SELECT * FROM customers_cells");
                                    // $statement  = $this->_db->prepare($query);
                                    // $statement->execute();
                                    // if ($statement->rowCount() == 0) {
                                    // echo $statement->rowCount();
                                    $insert_query = ("INSERT INTO customers_cells(customer_id,date,call_duration,dialed_phone_number,customer_ip)
                                            VALUES ('" . $customer_id . "' ,'" . $date . "', '" . $call_duration . "', '" . $dialed_phone_number . "', '" . $customer_ip . "')");
                                    $statement  = $this->_db->prepare($insert_query);
                                    $statement->execute();
                                    //     // ! cell the html table or drop table
                                    // } else {
                                    //     echo $statement->rowCount() . '1';
                                    // }
                                }
                                $skip++;
                            }
                        } catch (PDOException $e) {
                            die($e->getMessage());
                        }
                        $newtargetfile = $target_file;
                        if (file_exists($newtargetfile)) {
                            unlink($newtargetfile);
                        }
                    }
                }
            }
        }
    }
    public function setForm()
    {

        $output = '<div class="card">
                    <div class="card-body">
                        <form id="upload_csv" method="post" enctype="multipart/form-data">
                        <div class="spinner">
                        <div class="lds-ring"><div></div><div></div><div></div><div></div></div>
                        </div>
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
                </div>';
        return $output;
    }
}