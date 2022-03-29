<?php

namespace App\Controller;

use App\Repository\SignBindRepository;
use App\Repository\SignRepository;
use App\Service\Classificator\ClassificatorService;
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

    public function __construct(
        ClassificatorService $classificatorService
    ) {
        $this->classificatorService = $classificatorService;
    }

    /**
     * @Route("/classificator", name="app_classificator")
     */
    public function index(Request $request): Response
    {
        $signSerialize = $this->classificatorService->prepareSignBindToForm();
        $form = $this->createFormBuilder();
        $i = 0;
        foreach ($signSerialize as $serialize) {
            $form->add('value' . $i, ChoiceType::class, [
                'label' => $serialize['name'] . ' ',
                'choices' => $serialize['value'],
            ]);
            ++$i;
        }
        $form->add(
            'save',
            SubmitType::class,
            ['label' => 'Классифицировать']
        );
        $form = $form->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $classificationArray = $this->classificatorService->getClassification($form->getData());
//            dd($classificationArray);
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
