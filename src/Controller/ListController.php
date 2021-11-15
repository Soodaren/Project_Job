<?php

namespace App\Controller;

use App\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ListController extends AbstractController
{
    /**
     * @Route("/list", name="list")
     */
    public function index(): Response
    {

        $job = $this->getDoctrine()
            ->getRepository(Job::class)
            ->findAll();

        return $this->render('list/index.html.twig',
            array('job' => $job)
        );
    }
}
