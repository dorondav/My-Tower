<?php
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

        if (!file_exists($destination)) {
            return "Error: countryInfo.txt not found";
        }
        #---------------------CODE FOR TABLES CREATION AND DATABASE INSERTION----------------------

        #Code for truncating the already inserted database the tables

        $query = "TRUNCATE " . 'geo_country';
        $statement1  = $this->_db->prepare($query);
        $statement1->execute();

        #Array of filename and the table name 
        // Add slashes to path
        $ipsPath = addslashes(DPATH);

        try {
            $tablename =  array('countryInfo.txt', 'geo_country');
            $query  =   "LOAD DATA LOCAL INFILE '" . $ipsPath . $tablename['0'] . "' IGNORE INTO TABLE `" . $tablename['1'] . "` CHARACTER SET UTF8;";
            $statement  = $this->_db->prepare($query);
            // echo $query;
            $statement->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }

        // #Delete empty rows from countryInfo
        $query = "DELETE FROM geo_country where iso_alpha2 LIKE '#%'; ";
        $statement  = $this->_db->prepare($query);
        $statement->execute();
    }
}