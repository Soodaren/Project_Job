<?php

namespace App\Service;

use App\Entity\Artist;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class MusicService
{

    const TOKEN = "BQBpbf2YbhCaL3diIDxT77--DQYAiEMlt3uZo9MEfC4ZAOCtOJrJDPGuX3XrTnPC3NOFY8c1j1K-cPBQJrPqvNaNNSCfTRtiaJPU5YZJbptRfEelmfpl2Vftos5NB5i5B9DzsycOKvRrKySd9xr_HqHmS93enDE";
    const URL = "https://api.spotify.com/";

    /**
     * @throws GuzzleException
     */
    public function getMusic(){
        $client = new Client(['base_uri' => self::URL]);

        $response = $client->request(
            'GET',
            'v1/albums?ids=382ObEPsp2rxGrnsizN5TX%2C1A2GTWGtFfWp7KSQTwWOyo%2C2noRn2Aes5aoNVsU6iWThc&market=ES',
            ['headers' => [
                'Authorization' => 'Bearer ' . self::TOKEN,
                'Accept'        => 'application/json',
            ]]
        )->getBody()->getContents();

        return json_decode($response, true);

    }

    /**
     * @throws GuzzleException
     */
    public function createArtist($albums){
        $this->getMusic();
        foreach($albums['albums'] as $album){
            foreach ($album['artists'] as $artist){
                $name = $artist['name'];

                $artist = new Artist();
                $artist->setName($name);
            }
        }
    }
}