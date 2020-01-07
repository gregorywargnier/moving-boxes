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
 * @Route("/moving", name="movings:app")
 */
class MovingsController extends AbstractController
{
    /**
     * @Route("s", name=":index", methods={"HEAD","GET"})
     */
    public function index(MovingsRepository $movingsRepository): Response
    {
        return $this->render('movings/index.html.twig', [
            'movings' => $movingsRepository->findAll(),
        ]);
    }

    /**
     * @Route("", name=":create", methods={"HEAD","GET","POST"})
     */
    public function create(Request $request): Response
    {
        $moving = new Movings();
        $form = $this->createForm(MovingsType::class, $moving);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($moving);
            $entityManager->flush();

            return $this->redirectToRoute('movings:app:index');
        }

        return $this->render('movings/new.html.twig', [
            'moving' => $moving,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name=":read", methods={"HEAD","GET"})
     */
    public function read(Movings $moving): Response
    {
        return $this->render('movings/read.html.twig', [
            'moving' => $moving,
        ]);
    }

    /**
     * @Route("/{id}/edit", name=":update", methods={"HEAD","GET","POST"})
     */
    public function update(Request $request, Movings $moving): Response
    {
        $form = $this->createForm(MovingsType::class, $moving);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('movings:app:index');
        }

        return $this->render('movings/update.html.twig', [
            'moving' => $moving,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=":delete", methods={"HEAD","GET","DELETE"})
     */
    public function delete(Request $request, Movings $moving): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moving->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($moving);
            $entityManager->flush();
        }

        return $this->redirectToRoute('movings:app:index');
    }
}
