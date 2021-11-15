<?php

namespace App\Controller;

use App\Entity\Job;
use App\Form\JobType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AddJobController extends AbstractController
{
    /**
     * @Route("/addjob", name="addJob")
     */

    public function index(Request $request): Response
    {
        $job = new Job();

        $form = $this->createForm(JobType::class, $job);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $job->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('images_directory'), $fileName);
            $job->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return $this->redirectToRoute('list');
        }
        return $this->render('add_job/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editJob/{id}", name="edit_job")
     */
    public function edit(Request $request, $id): Response
    {
        $job = $this->getDoctrine()
            ->getRepository(Job::class)
            ->find($id);

        if(!$job){
            throw $this->createNotFoundException('No job found');
        }

        $form = $this->createForm(JobType::class, $job);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $job->getImage();
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();
            $file->move($this->getParameter('images_directory'), $fileName);
            $job->setImage($fileName);

            $em = $this->getDoctrine()->getManager();
            $em->persist($job);
            $em->flush();

            return $this->redirectToRoute('list');
        }
        return $this->render('add_job/edit.html.twig', [
            'edit' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deleteJob/{id}", name="delete_job")
     */
    public function delete($id): Response
    {
        $job = $this->getDoctrine()->getRepository(Job::class)->find($id);

        if ($job != null) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($job);
            $em->flush();
        }
        return $this->redirectToRoute('list');
    }

}
