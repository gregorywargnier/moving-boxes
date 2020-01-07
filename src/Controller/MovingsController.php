<?php

namespace App\Controller;

use App\Entity\Movings;
use App\Form\MovingsType;
use App\Repository\MovingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/movings")
 */
class MovingsController extends AbstractController
{
    /**
     * @Route("/", name="movings_index", methods={"GET"})
     */
    public function index(MovingsRepository $movingsRepository): Response
    {
        return $this->render('movings/index.html.twig', [
            'movings' => $movingsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="movings_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $moving = new Movings();
        $form = $this->createForm(MovingsType::class, $moving);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($moving);
            $entityManager->flush();

            return $this->redirectToRoute('movings_index');
        }

        return $this->render('movings/new.html.twig', [
            'moving' => $moving,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movings_show", methods={"GET"})
     */
    public function show(Movings $moving): Response
    {
        return $this->render('movings/show.html.twig', [
            'moving' => $moving,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="movings_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Movings $moving): Response
    {
        $form = $this->createForm(MovingsType::class, $moving);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('movings_index');
        }

        return $this->render('movings/edit.html.twig', [
            'moving' => $moving,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="movings_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Movings $moving): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moving->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($moving);
            $entityManager->flush();
        }

        return $this->redirectToRoute('movings_index');
    }
}
