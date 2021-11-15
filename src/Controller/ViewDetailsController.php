<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewDetailsController extends AbstractController
{
    /**
     * @Route("/viewDetails/{id}", name="view_details")
     */
    public function index($id): Response
    {

        $job = $this->getDoctrine()
            ->getRepository(Job::class)
            ->find($id);

        return $this->render('view_details/index.html.twig', array(
            'data' => $job
        ));
    }
}
