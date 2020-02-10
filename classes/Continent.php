<?php
class Continent
{
    public $_db = null,
        $continent = array();
    public function __construct()
    {
        $this->_db = DB::getInstance();
    }
    public function checkIp($ip)
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

    public function customerLocation()
    {
        // need fo get $id, $ip;
        $continent = array();
        try {
            $query = ("SELECT customer_id, customer_ip
             FROM 
             customers_cells
             GROUP BY  customer_id");
            $stmt  = $this->_db->prepare($query);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $row) {
                if ($row !== '') {
                    // $continent["id"] = $row["customer_id"];
                    // $continent["continent"] =  $this->checkIp($row["customer_ip"]);

                    $continent[] = [
                        "id" =>  $row["customer_id"],
                        "continent" => $this->checkIp($row["customer_ip"])
                    ];
                }
            }
            return $continent;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
}