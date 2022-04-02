<?php

namespace App\Controller;

use App\Repository\GenreRepository;
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

    private GenreRepository $genreRepository;

    public function __construct(
        FormService $formService,
        ClassificatorService $classificatorService,
        GenreService $genreService,
        GenreRepository $genreRepository
    )
    {
        $this->formService = $formService;
        $this->classificatorService = $classificatorService;
        $this->genreService = $genreService;
        $this->genreRepository = $genreRepository;
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
     * @Route("/genre/update", name="genre_update")
     */
    public function getUpdatedGenre(Request $request): Response
    {
        $genreArray = $this->genreService->prepareGenreForDelete();
        $form = $this->createFormBuilder();
        $form->add('genre', ChoiceType::class, [
            'label' => 'Выберите жанр',
            'choices' => $genreArray
        ]);
        $form->add('select', SubmitType::class, ['label' => 'Выбрать жанр']);
        $form = $form->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $id = $form->getData()['genre'];
            return $this->redirectToRoute('genre_update_by_id', ['id' => $id]);
        }
        return $this->renderForm('genre/GenreDelete.html.twig', [
            'form' => $form
        ]);
    }


    /**
     * @Route("/genre/update/{id}", name="genre_update_by_id")
     */
    public function updateGenre(Request $request, int $id): Response
    {
        $signForGenre = $this->genreService->getSignForGenre($id);
        $form = $this->createFormBuilder();
        $form = $this->formService->makeGenreFormForUpdate($form, 'Изменить жанр');
        $form = $form->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $this->classificatorService->removeNullValue($form->getData());
            $error = $this->genreService->updateGenre($id, $formData);
            return $this->render('genre/GenreUpdatingAnswer.html.twig', [
                'error' => $error
            ]);
        }
        return $this->renderForm('genre/GenreUpdate.html.twig', [
            'form' => $form,
            'name' => $this->genreRepository->find($id)->getName(),
            'signs' => $signForGenre
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
        $form->add('delete', SubmitType::class, ['label' => 'Удалить жанр']);
        $form = $form->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $id = $form->getData()['genre'];
            $this->genreService->deleteGenre($id);
            return $this->render('/genre/GenreDeletingAnswer.html.twig');
        }
        return $this->renderForm('genre/GenreDelete.html.twig', [
            'form' => $form
        ]);
    }
}
