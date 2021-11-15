<?php

namespace App\Controller;

use App\Entity\Job;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use http\Client\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {

        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('list');
        }

        $job = $this->getDoctrine()
            ->getRepository(Job::class)
            ->findAll();

        return $this->render('home/index.html.twig',
            array('job' => $job)
        );
    }

}
