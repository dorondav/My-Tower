<?php
class Continent
{
    static $_db = null;

    public $continent = array();
    public function __construct()
    {
        self::$_db = DB::getInstance();
    }
    private function checkIp($ip)
    {
        // set API access key 
        $access_key = 'd9f000dbc0237078dfb39bf8033d244c';

        // Initialize CURL:
        $ch = curl_init('http://api.ipstack.com/' . $ip . '?access_key=' . $access_key . '');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Store the data:
        $json = curl_exec($ch);
        curl_close($ch);

        // Decode JSON response:
        $api_result = json_decode($json, true);

        // Output the "capital" object inside "location"
        return $api_result['continent_code'];
    }

    public static function customerLocation()
    {
        // need fo get $id, $ip;
        $continent = array();
        try {
            // Get IP per Customer;
            $query = ("SELECT customer_id, customer_ip
             FROM 
             customers_cells
             GROUP BY  customer_id");
            $stmt  = self::$_db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                if ($row !== '') {
                    $continent[] = [
                        "id" =>  $row["customer_id"],
                        "continent" => self::checkIp($row["customer_ip"])
                    ];
                }
            }
            return $continent;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}