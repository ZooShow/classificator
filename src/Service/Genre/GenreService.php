<?php

namespace App\Service\Genre;

use App\Entity\Genre;
use App\Entity\GenreSignBind;
use App\Entity\SignBind;
use App\Repository\GenreRepository;
use App\Repository\GenreSignBindRepository;
use Doctrine\ORM\EntityManagerInterface;
use Exception;

class GenreService
{

    private GenreRepository $genreRepository;

    private EntityManagerInterface $entityManager;

    private GenreSignBindRepository $genreSignBindRepository;

    public function __construct(
        GenreRepository $genreRepository,
        EntityManagerInterface $entityManager,
        GenreSignBindRepository $genreSignBindRepository
    ) {
        $this->genreRepository = $genreRepository;
        $this->entityManager = $entityManager;
        $this->genreSignBindRepository = $genreSignBindRepository;
    }

    public function addNewGenre(array $formData): bool
    {
        $name = $formData[0];
        $genreDuplicate = $this->genreRepository->findOneBy(['name' => $name]);
        if ($genreDuplicate) {
            return false;
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
        return true;
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
            $tmp[] = [
                $genre->getName() => $genre->getId()
            ];
        }
        return $tmp;
    }

    public function deleteGenre(int $id)
    {
        $genre = $this->genreRepository->find($id);
        $genreSignBind = $this->genreSignBindRepository->findBy(['genre' => $genre]);
        foreach ($genreSignBind as $item) {
            $this->genreSignBindRepository->remove($item, false);
        }
        $this->genreSignBindRepository->flushAll();
        $this->genreRepository->remove($genre);
//        dd($genreSignBind);
    }
}