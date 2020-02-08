<?php
class Continent
{
    public function getIp()
    {
        // set IP address and API access key 
        $ip = '134.201.250.155';
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
}