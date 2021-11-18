<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class JobService
{
    const TOKEN = "BQDVKd0-7IZTigJ3M9zg41k_IqiUefQ4pIo_y8U2PUwjVF69ybMGHft2pex5Qf2bkPngmR2CgIp9HroJ4RgzXYsmH9Oce4ZziLYiksGqDNTOtFytqPSceUDcqnHdRV4yPxjWFq1qIqXr7qkCi7cECuF8wtvhQHM";
    const URL = "https://api.spotify.com/";

    /**
     * @throws GuzzleException
     */
    public function getJob(){
        $client = new Client(['base_uri' => self::URL]);

        $headers = [
            'Authorization' => 'Bearer ' . self::TOKEN,
            'Accept'        => 'application/json',
        ];
        $response = $client->request(
            'GET',
            'v1/artists/0TnOYISbd1XYRBk9myaseg/albums?limit=10&offset=5',
            ['headers' => $headers]
        )->getBody()->getContents();

        return json_decode($response, true);
    }
}