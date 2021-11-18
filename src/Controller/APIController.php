<?php

namespace App\Controller;

use App\Service\JobService;
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
    public function apiSpotify(JobService $jobService): Response
    {
        $job = $jobService->getJob();

        return $this->render('api/index.html.twig', [
            'response' => $job
        ]);
    }
}
