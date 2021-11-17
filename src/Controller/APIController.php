<?php

namespace App\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{

    const TOKEN = "BQD-VXA8Pbs9FSYpTeUdtaOj_91f6E0gUUnaqHZjTnb92boM5-Vdm3g3R9zLlYADa1EfGkPsVcnztltyzbuv0t5VS_yH47Q0ct_g6HmdigcIXh39zWGWPTcEcosARe8z7ec8PxP5zso-MLQs_klWKJ2v--VaGRo";
    const URL = "https://api.spotify.com/";
    /**
     * @Route("/api", name="api")
     * @throws GuzzleException
     */
    public function apiSpotify(): Response
    {

        $client = new Client(['base_uri' => self::URL,'timeout' => 0]);

        $headers = [
            'Authorization' => 'Bearer ' . self::TOKEN,
            'Accept'        => 'application/json',
        ];
        $response = $client->request(
            'GET',
            'v1/artists/0TnOYISbd1XYRBk9myaseg/albums?limit=10&offset=5',
            ['headers' => $headers]
        )->getBody()->getContents();

        $response = json_decode($response, true);

        return $this->render('api/index.html.twig', [
            'response' => $response
        ]);
    }
}
