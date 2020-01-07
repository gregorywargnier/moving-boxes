<?php

namespace App\Controller;

use App\Entity\Boxes;
use App\Form\BoxesType;
use App\Repository\BoxesRepository;
use App\Repository\MovingsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/boxe", name="boxes:app")
 */
class BoxesController extends AbstractController
{
    // /**
    //  * @Route("s", name="boxes_index", methods={"GET"})
    //  */
    // public function index(BoxesRepository $boxesRepository): Response
    // {
    //     return $this->render('boxes/index.html.twig', [
    //         'boxes' => $boxesRepository->findAll(),
    //     ]);
    // }

    /**
     * @Route("", name=":create", methods={"HEAD","GET","POST"})
     */
    public function new(MovingsRepository $movingsRepository, Request $request): Response
    {
        // Retireve moving ID
        $moving = $request->get('moving');
        $moving = $moving ? $movingsRepository->find($moving) : null;


        $box = new Boxes();
        $form = $this->createForm(BoxesType::class, $box);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) 
        {
            $box->setMoving( $moving );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($box);
            $entityManager->flush();

            return $this->redirectToRoute('movings:app:read', [
                'id' => $moving->getId()
            ]);
        }

        return $this->render('boxes/create.html.twig', [
            'box' => $box,
            'moving' => $moving->getId(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name=":read", methods={"GET"})
     */
    public function show(Boxes $box): Response
    {
        return $this->render('boxes/show.html.twig', [
            'box' => $box,
        ]);
    }

    /**
     * @Route("/{id}/edit", name=":update", methods={"GET","POST"})
     */
    public function edit(Request $request, Boxes $box): Response
    {
        $form = $this->createForm(BoxesType::class, $box);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('boxes_index');
        }

        return $this->render('boxes/edit.html.twig', [
            'box' => $box,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="boxes_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Boxes $box): Response
    {
        if ($this->isCsrfTokenValid('delete'.$box->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($box);
            $entityManager->flush();
        }

        return $this->redirectToRoute('boxes_index');
    }
}
