<?php

namespace App\Controller;

use App\Entity\Apply;
use App\Entity\Job;
use App\Entity\User;
use App\Form\ApplicationType;
use App\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ApplicationController extends AbstractController
{
    /**
     * @Route("/application", name="application")
     */
    public function index(Request $request): Response
    {

        $id = $request->get('id');
        $job = $this->getDoctrine()
            ->getRepository(Job::class)
            ->find($id);

        $application = new Apply();

        $form = $this->createForm(ApplicationType::class, $application);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form->get('cv')->getData();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('document_directory'), $fileName);
            $application->setCv($fileName);

            /** @var User $user */
            $user = $this->getUser();

            $application->setUser($user);


            $application->setJob($job);

            $em = $this->getDoctrine()->getManager();
            $em->persist($application);
            $em->flush();

            return $this->redirectToRoute('list');
        }
        return $this->render('application/index.html.twig', [
            'form' => $form->createView(),
            'job' => $job
        ]);
    }
}
