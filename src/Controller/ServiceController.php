<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(): Response
    {
        return $this->render('service/index.html.twig', [
            'controller_name' => 'ServiceController',
        ]);
    }
    #[Route('/service/{name}', name : 'service')]
    public function showService(string $name): Response
    {
        return $this->render("service/showservice.html.twig", [
            'name' => $name,
        ]);
    }
    #[Route('/home', name: 'service_index')]
    public function goToIndex(): Response
    {
        return $this->redirectToRoute('app_home'); 
    }

}
