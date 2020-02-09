<?php

class DB
{
    private static $_instance = null;
    private $_pdo;
    private $db;
    private function __construct()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '-1');

        #***********************************Changes to be done here**************************************************
        $host   = "localhost";
        $username = "root";
        $password = "";
        $dbname = "mytowerdoron";

        // Path to the countryinfo file: /assets/;
        define('DPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR);
        #*****************************************************************************	

        try {
            $this->_pdo = new PDO("mysql:host=$host", $username, $password, array(
                PDO::MYSQL_ATTR_LOCAL_INFILE => true
            ));
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->_pdo->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES utf8");

            # Create Database if not exists
            $dbname = "`" . str_replace("`", "``", $dbname) . "`";
            $this->_pdo->query("CREATE DATABASE IF NOT EXISTS $dbname");
            $this->_pdo->query("use $dbname");
            #---------------------INITIALIZE TABLES ----------------------
            # Create GeoName Table if not Exists
            $this->initGeoNamesTable();
            # Create CSV Table if not Exists
            $this->initCsvTable();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function initGeoNamesTable()
    {
        // Create GeoName Table if not Exists
        try {
            $sql = "CREATE TABLE IF NOT EXISTS `geo_country` (
                `iso_alpha2` char(2) NOT NULL DEFAULT '',
                `iso_alpha3` char(3) DEFAULT NULL,
                `iso_numeric` int(11) DEFAULT NULL,
                `fips_code` varchar(3) DEFAULT NULL,
                `name` varchar(200) DEFAULT NULL,
                `capital` varchar(200) DEFAULT NULL,
                `areainsqkm` double DEFAULT NULL,
                `population` int(11) DEFAULT NULL,
                `continent` char(2) DEFAULT NULL,
                `tld` char(3) DEFAULT NULL,
                `currency` char(3) DEFAULT NULL,
                `currencyName` char(20) DEFAULT NULL,
                `Phone` char(10) DEFAULT NULL,
                `postalCodeFormat` char(20) DEFAULT NULL,
                `postalCodeRegex` char(90) DEFAULT NULL,
                `geonameId` int(11) DEFAULT NULL,
                `languages` varchar(200) DEFAULT NULL,
                `neighbours` char(20) DEFAULT NULL,
                `equivalentFipsCode` char(10) DEFAULT NULL,
                PRIMARY KEY (`iso_alpha2`),
                KEY `iso_alpha3` (`iso_alpha3`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $this->_pdo->exec($sql);
            return  $this->_pdo;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    private function initCsvTable()
    {
        // Create GeoName Table if not Exists
        try {
            $sql = "CREATE TABLE IF NOT EXISTS `customers_cells`(
                `row_id` INT(5) NOT NULL AUTO_INCREMENT,
                `customer_id` INT(6) NOT NULL ,
                `date` VARCHAR(11) NOT NULL , 
                `call_duration` INT(6) NOT NULL ,
                `dialed_phone_number` VARCHAR(11) NOT NULL ,
                `customer_ip` VARCHAR(17) NOT NULL ,
                PRIMARY KEY (`row_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
            $this->_pdo->exec($sql);
            return  $this->_pdo;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance->_pdo;
    }

    public function getConnection()
    {
        return $this->db;
    }
}