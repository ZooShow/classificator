<?php

namespace App\Controller;

use App\Entity\Sign;
use App\Repository\SignTypeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\SignRepository;
use App\Repository\SignBindRepository;

class SignController extends AbstractController
{
    /**
     * @var SignRepository
     */
    private SignRepository $signRepository;

    /**
     * @var SignBindRepository
     */
    private SignBindRepository $signBindRepository;

    /**
     * @var SignTypeRepository
     */
    private SignTypeRepository $signTypeRepository;

    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;

    public function __construct(
        SignBindRepository $signBindRepository,
        SignRepository $signRepository,
        SignTypeRepository $signTypeRepository,
        ManagerRegistry $managerRegistry
    ) {
        $this->signBindRepository = $signBindRepository;
        $this->signRepository = $signRepository;
        $this->signTypeRepository = $signTypeRepository;
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * @Route("/sign", name="print_sign")
     */
    public function printTable(): Response
    {
        $signSerialize = $this->getSignSerialize();
        return $this->render('Sign/SignesTable.html.twig', [
            'signs' => $signSerialize
        ]);
    }

    private function getSignSerialize(): array
    {
        $signSerialize = [];
        $signs = $this->signRepository->findAll();
        foreach ($signs as $sign) {
            $signBinds = $this->signBindRepository->findBy(['sign' => $sign]);
            $bindSerialize = '';
            foreach ($signBinds as $signBind) {
                $bindSerialize .= ', ' . $signBind->getValue();
            }
            $signSerialize[] = [
                'name' => $sign->getName(),
                'type' => $sign->getSignType()->getName(),
                'value' => substr($bindSerialize, 1)
            ];
        }
        return $signSerialize;
    }

    /**
     * @Route("/sign/add", name="app_sign")
     */
    public function showAddSign(Request $request): ?Response
    {
        $form = $this->createFormBuilder()
            ->add('name', TextType::class, ['label' => 'Название '])
            // ToDo добавить сюда типы из бд
            ->add('type', ChoiceType::class, [
                'label' => 'Тип ',
                'choices' => [
                    'Размерный' => 1,
                    'Скалярный' => 2,
                    'Логический' => 3,
                ],
            ])
            ->add('value', TextType::class, ['label' => 'Возможные значения: '])
            ->add('save', SubmitType::class, ['label' => 'Создать признак'])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $name = $form->getData()['name'];
            $type = $this->signTypeRepository->find($form->getData()['type']);
            $duplicate = $this->signRepository->findBy([
                'name' => $name,
                'signType' => $type
            ]);
            if ($duplicate) {
                return $this->redirectToRoute('error_add_sign');
            }
            $sign = new Sign();

            $sign->setName($name);

            $sign->setSignType($type);
            $em = $this->managerRegistry->getManagerForClass(get_class($sign));
            $em->persist($sign);
            $em->flush();
            return $this->redirectToRoute('app_sign');
        }
        return $this->renderForm('Sign/SignAdd.html.twig', [
                'form' => $form,
            ]
        );
    }

    /**
     * @Route("/sign/error", name="error_add_sign")
     */
    public function duplicateSign(): Response
    {
        return $this->render('Sign/SignError.html.twig', []);
    }
}
