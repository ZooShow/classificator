<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClassificatorController extends AbstractController
{
    /**
     * @Route("/classificator", name="app_classificator")
     */
    public function index(): Response
    {
        return $this->render('classificator/index.html.twig', [
            'controller_name' => 'ClassificatorController',
        ]);
    }
}
