<?php

namespace App\Controller;

use App\Entity\Movings;
use App\Entity\UsersMovings;
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
        // 1. Retrieve Entities
        // --

        // Get current user
        $user = $this->getUser();

        // Get all moving for $user
        $movings = $movingsRepository->findByUser($user);


        // 2. Render response
        // --

        return $this->render('movings/index.html.twig', [
            'movings' => $movings,
        ]);
    }

    /**
     * @Route("", name=":create", methods={"HEAD","GET","POST"})
     */
    public function create(Request $request): Response
    {
        // 1. Retrieve Entities
        // --

        // New Moving
        $moving = new Movings();

        // New User Moving relationship
        $userMoving = new UsersMovings();

        // Get current user
        $user = $this->getUser();


        // 2. Create form
        // --

        // Create new form based on the Moving Entity
        $form = $this->createForm(MovingsType::class, $moving);

        // Handle the Request (request method === post)
        $form->handleRequest($request);

        // On form submit
        if ($form->isSubmitted() && $form->isValid()) 
        {
            // Make User/Moving relation
            $userMoving->setMoving($moving);
            $userMoving->setUser($user);

            // Save in database
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($moving);
            $entityManager->persist($userMoving);
            $entityManager->flush();

            return $this->redirectToRoute('movings:app:index');
        }

        // Create the form view
        $form = $form->createView();


        // 3. Render response
        // --

        return $this->render('movings/new.html.twig', [
            'moving' => $moving,
            'form' => $form,
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
