<?php

namespace App\Controller;

use App\Entity\Festival;
use App\Repository\DepartementRepository;
use App\Repository\FestivalRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\VarDumper\VarDumper;

class FestivalController extends AbstractController
{
    #[Route('/', name: 'app_festival')]
    public function index(FestivalRepository $festivalRepository, DepartementRepository $departementRepository): Response
    {
        $festivals = $festivalRepository->findBy([],['createdAt'=>'DESC'], 3);
        $departements = $departementRepository->findAll();
        return $this->render('festival/index.html.twig',compact('festivals','departements'));
    }

    #[Route('/festival/{id}', name: 'app_festival_show')]
    public function show(int $id, FestivalRepository $festivalRepository): Response
    {
        $festival = $festivalRepository->find($id);
        return $this->render('festival/show.html.twig',compact('festival'));
    }
}
