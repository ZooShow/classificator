<?php

namespace App\Service\Classificator;


use App\Repository\GenreRepository;
use App\Repository\GenreSignBindRepository;
use App\Repository\SignBindRepository;
use App\Repository\SignRepository;

class ClassificatorService
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
     * @var GenreSignBindRepository
     */
    private GenreSignBindRepository $genreSignBindRepository;

    /**
     * @var GenreRepository
     */
    private GenreRepository $genreRepository;

    public function __construct(
        SignRepository $signRepository,
        SignBindRepository $signBindRepository,
        GenreSignBindRepository $genreSignBindRepository,
        GenreRepository $genreRepository
    ) {
        $this->signRepository = $signRepository;
        $this->signBindRepository = $signBindRepository;
        $this->genreSignBindRepository = $genreSignBindRepository;
        $this->genreRepository = $genreRepository;
    }

    /**
     * Классифицирует жанр
     * @param array $signBinds
     * @return array
     */
    public function getClassification(array $signBinds): array
    {
        $signBinds = $this->removeNullValue($signBinds);
        if (count($signBinds) === 0) {
            return [
                'error' => true,
                'possible_genre' => []
            ];
        }
        $genreSignBinds = $this->getGenreSignBindArray();
        $tmp = [];
        foreach ($genreSignBinds as $genreSignBind) {
            $tmp[] = [
                'name' => $genreSignBind['name'],
                'intersect' =>(int)
                (count(array_intersect($signBinds, $genreSignBind['signBind']))/count($genreSignBind['signBind']) * 100)
            ];
        }
        usort($tmp, function ($a1, $a2) {
            return $a2['intersect'] <=> $a1['intersect'];
        });
        return [
            'error' => false,
            'possible_genre' => $tmp
        ];
    }

    /**
     * Возвращает массив для формирования формы
     * @return array
     */
    public function prepareSignBindToForm(): array
    {
        $signs = $this->signRepository->findAll();
        $signSerialize = [];
        foreach ($signs as $sign) {
            $signBinds = $this->signBindRepository->findBy(['sign' => $sign]);
            $bindSerialize = [-1 => 'Не определено'];
            foreach ($signBinds as $signBind) {
                $bindSerialize[$signBind->getId()] = $signBind->getValue();
            }
            $bindSerialize = array_flip($bindSerialize);
            $signSerialize[] = [
                'name' => $sign->getName(),
                'value' => $bindSerialize,
            ];
        }
        return $signSerialize;
    }

    /**
     * Убирает неопределенные признаки из массива
     * @param array $signBinds
     * @return array
     */
    public function removeNullValue(array $signBinds): array
    {
        $tmp = [];
        foreach ($signBinds as $signBind) {
            if ($signBind !== -1) {
                $tmp[] = $signBind;
            }
        }
        return $tmp;
    }

    /**
     * Возвращает ассоциативный массив жанр => [айди значений]
     * @return array
     */
    private function getGenreSignBindArray(): array
    {
        $genres = $this->genreRepository->findAll();
        $genreSignBind = [];
        foreach ($genres as $genre) {
            $genreSigns = $this->genreSignBindRepository->findBy(['genre' => $genre]);
            $tmp = [];
            foreach ($genreSigns as $genreSign) {
                $tmp[] = $genreSign->getSignBind()->getId();
            }
            $genreSignBind[] = [
                'name' => $genre->getName(),
                'signBind' => $tmp
            ];
        }
        return $genreSignBind;
    }
}