<?php

namespace App\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{

    const TOKEN = "BQCkaJXcO4uRoSRW6M6DVywA4-7f4oYD_-AENYCxZk1TQxVxNyGwrSon-HfZSbkQ7dgGz4h_gnpbMrsnonpO6iTr9XNY6M5l1pHv1lLs-JZZe71MwjESlaj1Xq9xfGWfSoFy9-BFFl5y5TYsPwWwoPvwtpo-dmI";
    const URL = "https://api.spotify.com/";
    /**
     * @Route("/api", name="api")
     * @throws GuzzleException
     */
    public function Api(): Response
    {

        $client = new Client(['base_uri' => self::URL,'timeout' => 0]);

        $headers = [
            'Authorization' => 'Bearer ' . self::TOKEN,
            'Accept'        => 'application/json',
        ];
        $response = $client->request(
            'GET',
            'v1/artists/0TnOYISbd1XYRBk9myaseg/albums',
            ['headers' => $headers]
        )->getBody()->getContents();

        $response = json_decode($response, true);

        return $this->render('api/index.html.twig', [
            'response' => $response
        ]);
    }
}
