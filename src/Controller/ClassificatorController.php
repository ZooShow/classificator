<?php

namespace App\Controller;

use App\Repository\SignBindRepository;
use App\Repository\SignRepository;
use App\Service\Classificator\ClassificatorService;
use App\Service\Form\FormService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClassificatorController extends AbstractController
{
    /**
     * @var ClassificatorService
     */
    private ClassificatorService $classificatorService;

    /**
     * @var FormService
     */
    private FormService $formService;

    public function __construct(FormService $formService)
    {
        $this->formService = $formService;
    }

    /**
     * @Route("/classificator", name="app_classificator")
     */
    public function index(Request $request): Response
    {
        $form = $this->createFormBuilder();
        $form = $this->formService->makeGenreForm($form,'Классифицировать');
        $form = $form->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $classificationArray = $this->classificatorService->getClassification($form->getData());
            return $this->render('/Classificator/ClassificatorAnswer.html.twig', [
                'answers' => $classificationArray
            ]);
        }
        {
            return $this->renderForm('Classificator/Classificator.html.twig', [
                'form' => $form,
            ]);
        }
    }
}
