<?php

namespace App\Controller;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class APIController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     * @throws GuzzleException
     */
    public function Api(): Response
    {
        // Create a client with a base URI
        $client = new Client(['base_uri' => 'https://api.spotify.com/']);

        $token = "BQBjq99Zw_M8uCMzl3gO_fx2dU5Cz_bVetdG7Q2GGWJwlYKXxitaVh9WPzUpYbsHCV0fVGREhZIR-kMylm89LlPedS_iZ81Tcie9eFsztZ5OOtxljKczNqpM0PD_PTGL0N1GTlOALvNrZHoOJ5wEhGerw5wJjMI";
        $headers = [
            'Authorization' => 'Bearer ' . $token,
            'Accept'        => 'application/json',
        ];
        $response = $client->request(
            'GET',
            'v1/playlists/3cEYpjA9oz9GiPac4AsH4n/tracks',
            ['headers' => $headers]
        )->getBody()->getContents();

        $response = json_decode($response, true);
        return $this->render('api/index.html.twig', [
            'api' => $response
        ]);
    }
}
