<?php
require_once('DB.php');
class GeoName
{
    private  $_db = null;
    public function __construct()
    {
        $this->_db = DB::getInstance();
    }

    public function fetchCountryInfo()
    {
        // Get File Information
        $file = "countryInfo.txt";

        if (!file_exists(DPATH)) {
            $dirMode = 0777;
            $directory = DPATH;
            mkdir($directory, $dirMode, true);
            chmod($directory, $dirMode);
        }
        $destination = DPATH . $file;
        // ! remove the commented error message before sending this 
        if (file_exists($destination)) {
            // echo "The file <b>$file</b> already exists in the download Folder<br> ";
        } else {

            $ch = curl_init();
            $source = "http://download.geonames.org/export/dump/$file ";
            curl_setopt($ch, CURLOPT_URL, $source);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $data = curl_exec($ch);
            curl_close($ch);
            $file = fopen($destination, "w+");
            fputs($file, $data);
            fclose($file);
        }

        #---------------------CODE FOR TABLES CREATION AND DATABASE INSERTION----------------------

        #Code for truncating the already inserted database the tables


        #Array of filename and the table name 
        $tablename =  array('countryInfo.txt', 'geo_country');

        $query  =   "load data infile '" . DPATH . $tablename['0'] . "' IGNORE INTO TABLE " . $tablename['1'] . " CHARACTER SET UTF8;";
        $statement  = $this->_db->prepare($query);
        $statement->execute();
    }
    public function insertData()
    {
    }
}