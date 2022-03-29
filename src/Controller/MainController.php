<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @var string
     */
    private string $domain;

    public function __construct()
    {
        $this->domain = 'http://127.0.0.1:8000/';
    }

    /**
     * @Route("/main", name="app_main")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'domain' => $this->domain,
        ]);
    }
}
