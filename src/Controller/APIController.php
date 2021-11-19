<?php

namespace App\Controller;

use App\Service\MusicService;
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
    public function apiSpotify(MusicService $musicService): Response
    {
        $music = $musicService->getMusic();

        return $this->render('api/index.html.twig', [
            'response' => $music
        ]);
    }
}
