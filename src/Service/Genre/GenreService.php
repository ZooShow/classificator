<?php

namespace App\Service\Genre;

use App\Entity\Genre;
use App\Entity\GenreSignBind;
use App\Entity\SignBind;
use App\Repository\GenreRepository;
use App\Repository\GenreSignBindRepository;
use App\Repository\SignBindRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class GenreService
{

    private GenreRepository $genreRepository;

    private EntityManagerInterface $entityManager;

    private GenreSignBindRepository $genreSignBindRepository;

    private SignBindRepository $signBindRepository;

    public function __construct(
        GenreRepository $genreRepository,
        EntityManagerInterface $entityManager,
        GenreSignBindRepository $genreSignBindRepository,
        SignBindRepository $signBindRepository
    ) {
        $this->genreRepository = $genreRepository;
        $this->entityManager = $entityManager;
        $this->genreSignBindRepository = $genreSignBindRepository;
        $this->signBindRepository = $signBindRepository;
    }

    public function updateGenre(int $id, array $formData): array
    {
        if (count($formData) === 0) {
            return [
                'title' => 'Изменение жанра',
                'message' => 'У жанра должен быть хотя бы один признак!'
            ];
        }
        $genre = $this->genreRepository->find($id);
        $genreSignBind = $this->genreSignBindRepository->findBy(['genre' => $genre]);
        foreach ($genreSignBind as $item) {
            $this->genreSignBindRepository->remove($item, false);
        }
        $this->genreSignBindRepository->flushAll();
        foreach ($formData as $item) {
            $genreSignBindNew = new GenreSignBind();
            $signBind = $this->signBindRepository->find($item);
            $genreSignBindNew->setGenre($genre);
            $genreSignBindNew->setSignBind($signBind);
            $this->genreSignBindRepository->add($genreSignBindNew);
        }
        return [
            'title' => 'Изменение жанра',
            'message' => 'Жанр ' . $genre->getName() . ' успешно изменен!'
        ];
    }

    public function addNewGenre(array $formData): array
    {
        if (count($formData) < 2) {
            return [
                'title' => 'Добавление жанра',
                'message' => 'У жанра должен быть хотя бы один признак!'
            ];
        }
        $name = $formData[0];
        if (empty($name)) {
            return [
                'title' => 'Добавление жанра',
                'message' => 'Имя не должно состоять только из пробелов!'
            ];
        }

        $genreDuplicate = $this->genreRepository->findOneBy(['name' => $name]);
        if ($genreDuplicate) {
            return [
                'title' => 'Добавление жанра',
                'message' => 'Жанра с таким именем уже существует!'
            ];
        }
        $genre = new Genre();
        $genre->setName($name);
        $this->genreRepository->add($genre);
        unset(
            $formData[0]
        );
        foreach ($formData as $item) {
            $signBind = $this->entityManager->getReference(SignBind::class, $item);
            $genreSignBind = new GenreSignBind();
            $genreSignBind->setGenre($genre);
            $genreSignBind->setSignBind($signBind);
            $this->genreSignBindRepository->add($genreSignBind, false);
        }
        $this->genreSignBindRepository->flushAll();
        return [
            'title' => 'Добавление жанра',
            'message' => 'Жанр ' . $name . ' успешно добавлен!'
        ];
    }

    public function getAllGenres(): array
    {
        $genres = $this->genreRepository->findAll();
        $tmp = [];
        foreach ($genres as $genre) {
            $genreSignBinds = $this->genreSignBindRepository->findBy(['genre' => $genre]);
            $bindSerialize = [];
            foreach ($genreSignBinds as $genreSignBind) {
                $genreSignBindSerialize = $genreSignBind->getSignBind();
                $bindSerialize [] = [
                    'name' => $genreSignBindSerialize->getSign()->getName(),
                    'value' => $genreSignBindSerialize->getValue()
                ];

            }
            $tmp[] = [
                'name' => $genre->getName(),
                'value' => $bindSerialize
            ];
        }
        return $tmp;
    }

    public function prepareGenreForDelete(): array
    {
        $genres = $this->genreRepository->findAll();
        $tmp = [];
        foreach ($genres as $genre) {
            $tmp[$genre->getName()] = (int)$genre->getId();
        }
        return $tmp;
    }

    public function deleteGenre(int $id): array
    {
        $genre = $this->genreRepository->find($id);
        $genreSignBind = $this->genreSignBindRepository->findBy(['genre' => $genre]);
        foreach ($genreSignBind as $item) {
            $this->genreSignBindRepository->remove($item, false);
        }
        $this->genreSignBindRepository->flushAll();
        $this->genreRepository->remove($genre);
        return [
            'title' => 'Удаление жанра',
            'message' => 'Жанр ' . $genre->getName() . ' успешно удален!'
        ];
    }

    public function getSignForGenre(int $id): array
    {
        $genre = $this->genreRepository->find($id);
        $genreSignBinds = $this->genreSignBindRepository->findBy(['genre' => $genre]);
        $bindSerialize = [];
        foreach ($genreSignBinds as $genreSignBind) {
            $genreSignBindSerialize = $genreSignBind->getSignBind();
            $bindSerialize [] = [
                'name' => $genreSignBindSerialize->getSign()->getName(),
                'value' => $genreSignBindSerialize->getValue()
            ];

        }
        return $bindSerialize;
    }
}