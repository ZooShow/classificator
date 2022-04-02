<?php

namespace App\Controller;

use App\Service\Classificator\ClassificatorService;
use App\Service\Form\FormService;
use App\Service\Genre\GenreService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GenreController extends AbstractController
{

    private FormService $formService;

    private ClassificatorService $classificatorService;

    private GenreService $genreService;

    public function __construct(
        FormService $formService,
        ClassificatorService $classificatorService,
        GenreService $genreService
    )
    {
        $this->formService = $formService;
        $this->classificatorService = $classificatorService;
        $this->genreService = $genreService;
    }

    /**
     * @Route("/genre", name="genre_see")
     */
    public function getAllGenre(): Response
    {
        $genreArray = $this->genreService->getAllGenres();
        return $this->render('genre/GenreTable.html.twig', [
            'genres' => $genreArray
        ]);
    }

    /**
     * @Route("/genre/add", name="genre_add")
     */
    public function addGenre(Request $request): Response
    {
        $form = $this->createFormBuilder();
        $form->add('name',
            TextType::class,
            ['label' => 'Название класса']);
        $form = $this->formService->makeGenreForm($form, 'Создать жанр');
        $form = $form->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $this->classificatorService->removeNullValue($form->getData());
            $error = $this->genreService->addNewGenre($formData);
                return $this->render('genre/GenreAddingAnswer.html.twig', [
                    'error' => $error
                ]);
        }
        return $this->renderForm('genre/GenreAdd.html.twig', [
            'form' => $form
        ]);
    }

    /**
     * @Route("/genre/delete", name="genre_delete")
     */
    public function deleteGenre(Request $request): Response
    {
        $genreArray = $this->genreService->prepareGenreForDelete();
        $form = $this->createFormBuilder();
        $form->add('genre', ChoiceType::class, [
            'label' => 'Выберите жанр',
            'choices' => $genreArray
        ]);
        $form->add('delete', SubmitType::class, ['label' => 'Удалить признак']);
        $form = $form->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $id = $form->getData()['genre'];
            $this->genreService->deleteGenre($id);
//            dd($id);
        }
        return $this->renderForm('genre/GenreDelete.html.twig', [
            'form' => $form
        ]);
    }
}
