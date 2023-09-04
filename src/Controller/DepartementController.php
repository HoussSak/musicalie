<?php

namespace App\Controller;

use App\Entity\Departement;
use App\Repository\DepartementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DepartementController extends AbstractController
{
    #[Route('/departement', name: 'app_departement')]
    public function index(DepartementRepository $departementRepository): Response
    {
        $departements = $departementRepository->findAll();
        return $this->render('departement/index.html.twig',compact('departements'));
    }

    #[Route('/departement/{id}', name: 'app_departement_show', requirements:['id' => '\d+'])]
    public function show(int $id, DepartementRepository $departementRepository ): Response
    {
       $departement =  $departementRepository->find($id);
        return $this->render('departement/show.html.twig', compact('departement'));
    }
}
