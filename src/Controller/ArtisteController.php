<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Form\ArtisteType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArtisteController extends AbstractController
{
    #[Route('/artiste', name: 'app_artiste')]
    public function index(ArtisteRepository $repository): Response
    {
        $artistes = $repository->findBy([], ['createdAt'=>'DESC']);
        return $this->render('artiste/index.html.twig',compact('artistes'));
    }

    #[Route('/artiste/{id}', name: 'app_artiste_show', requirements:['id' => '\d+'])]
    public function show(int $id, ArtisteRepository $artisteRepository): Response
    {
        $artiste = $artisteRepository->find($id);
        return $this->render('artiste/show.html.twig',compact('artiste'));
    }

    #[Route('/artiste/create', name: 'app_artiste_create')]
    public function create(Request $request,EntityManagerInterface $em): Response
    {

        $artiste = new Artiste();
        $form=$this->createForm(ArtisteType::class,$artiste);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($artiste);
            $em->flush();

            $this->addFlash('success','artiste a été créé avec succès');

            return $this->redirectToRoute('app_artiste');
        }

        return $this->render('/artiste/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
