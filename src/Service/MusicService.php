<?php

namespace App\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MusicService
{

    const TOKEN = "BQCZteJOn5fa23CRt-NuIqZzcj7sMkzYxx5Ocf4ytAp6XQGdzu3UMsZE-sRNWbzt6-NviMkn8sR8FSW1rO2-4h2mHUs0_-yK4Ff2EpTdcw0ZvUt5T6e6dI8KN9GemFeMORoVRgUZMr7A7se8HEdc0q6PcWufJNg";
    const URL = "https://api.spotify.com/";

    /**
     * @throws GuzzleException
     */
    public function getMusic(){
        $client = new Client(['base_uri' => self::URL]);

        $response = $client->request(
            'GET',
            'v1/artists/0TnOYISbd1XYRBk9myaseg/albums?limit=10&offset=5',
            ['headers' => [
                'Authorization' => 'Bearer ' . self::TOKEN,
                'Accept'        => 'application/json',
            ]]
        )->getBody()->getContents();

        return json_decode($response, true);

    }
}