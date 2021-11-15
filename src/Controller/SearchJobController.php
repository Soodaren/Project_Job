<?php

namespace App\Controller;

use App\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchJobController extends AbstractController
{
    /**
     * @Route("/search/job", name="search_job")
     */
    public function searchJob(Request $request):Response
    {
        $title = $request->get('search');
        $em = $this->getDoctrine()->getManager();
        $search = $em->getRepository(Job::class)->findByTitle($title);

        $results = $search->getResult();

        $content = $this->renderView('partials/searchjob.html.twig', [
            'job' => $results
        ]);

        return new JsonResponse([
            'searchJob' => $content
        ]);
    }
}
