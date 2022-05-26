<?php

namespace App\Service;

use App\Repository\GenreRepository;
use App\Repository\GenreSignBindRepository;
use App\Repository\SignBindRepository;
use App\Repository\SignRepository;

class FullnesService
{
    private GenreSignBindRepository $genreSignBindRepository;

    private SignRepository $signRepository;

    private GenreRepository $genreRepository;

    private SignBindRepository $signBindRepository;

    public function __construct(
        GenreSignBindRepository $genreSignBindRepository,
        SignRepository $signRepository,
        GenreRepository $genreRepository,
        SignBindRepository $signBindRepository
    )
    {
        $this->genreSignBindRepository = $genreSignBindRepository;
        $this->signRepository = $signRepository;
        $this->genreRepository = $genreRepository;
        $this->signBindRepository = $signBindRepository;
    }

    public function checkDB(): bool
    {
        $genres = $this->genreRepository->findAll();

        foreach ($genres as $genre)
        {
            $signForGenre = $this->genreSignBindRepository->findBy(['genre' => $genre]);

            if (count($signForGenre) === 0) {
                return false;
            }
        }

        $signs = $this->signRepository->findAll();

        foreach ($signs as $sign) {
            $signBind = $this->signBindRepository->findBy(['sign' => $sign]);

            if (count($signBind) === 0) {
                return false;
            }
        }

        return true;
    }
}