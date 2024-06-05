<?php

namespace App\Controller;

use App\Entity\WsMembre;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(EntityManagerInterface $entityManager) : Response
    {
        $membres = $entityManager->getRepository(WsMembre::class)->findAll();
        return $this->render('index.html.twig', [
            "membres" => $membres
        ]);
    }
}
