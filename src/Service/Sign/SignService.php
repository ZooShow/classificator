<?php

namespace App\Service\Sign;

use App\Entity\GenreSignBind;
use App\Entity\Sign;
use App\Entity\SignBind;
use App\Repository\GenreSignBindRepository;
use App\Repository\SignBindRepository;
use App\Repository\SignRepository;
use App\Repository\SignTypeRepository;

class SignService
{

    /**
     * @var SignRepository
     */
    private SignRepository $signRepository;

    /**
     * @var SignTypeRepository
     */
    private SignTypeRepository $signTypeRepository;

    private SignBindRepository $signBindRepository;

    private GenreSignBindRepository $genreSignBindRepository;

    public function __construct(
        SignRepository $signRepository,
        SignTypeRepository $signTypeRepository,
        SignBindRepository $signBindRepository,
        GenreSignBindRepository $genreSignBindRepository
    )
    {
        $this->signRepository = $signRepository;
        $this->signTypeRepository = $signTypeRepository;
        $this->signBindRepository = $signBindRepository;
        $this->genreSignBindRepository = $genreSignBindRepository;
    }

    public function addRazmerniy(string $name): array
    {
        $duplicate = $this->signRepository->findBy(['name' => $name]);
        if ($duplicate) {
            return [
                'title' => 'Добавление признака',
                'message' => 'Признак с данным именем уже существует'
            ];
        }
        $type = $this->signTypeRepository->find(1);
        $sign = new Sign();
        $sign->setName($name);
        $sign->setSignType($type);
        $this->signRepository->add($sign);

        $signBind1 = new SignBind();
        $signBind1->setSign($sign);
        $signBind1->setValue('1');
        $this->signBindRepository->add($signBind1);

        $signBind2 = new SignBind();
        $signBind2->setSign($sign);
        $signBind2->setValue('>1');
        $this->signBindRepository->add($signBind2);

        return [
            'title' => 'Добавление признака',
            'message' => 'Признак ' . $name . ' успешно добавлен!'
        ];
    }

    public function addLogical(string $name): array
    {
        $duplicate = $this->signRepository->findBy(['name' => $name]);
        if ($duplicate) {
            return [
                'title' => 'Добавление признака',
                'message' => 'Признак с данным именем уже существует!'
            ];
        }
        $type = $this->signTypeRepository->find(3);

        $sign = new Sign();
        $sign->setName($name);
        $sign->setSignType($type);
        $this->signRepository->add($sign);

        $signBind1 = new SignBind();
        $signBind1->setSign($sign);
        $signBind1->setValue('Да');
        $this->signBindRepository->add($signBind1);

        $signBind2 = new SignBind();
        $signBind2->setSign($sign);
        $signBind2->setValue('Нет');
        $this->signBindRepository->add($signBind2);

        return [
            'title' => 'Добавление признака',
            'message' => 'Признак ' . $name . ' успешно добавлен!'
        ];
    }

    public function addScalarniy(array $data): array
    {
        $name = $data['name'];
        $duplicate = $this->signRepository->findBy(['name' => $name]);
        if ($duplicate) {
            return [
                'title' => 'Добавление признака',
                'message' => 'Признак с данным именем уже существует!'
            ];
        }
        $type = $this->signTypeRepository->find(2);

        $sign = new Sign();
        $sign->setName($name);
        $sign->setSignType($type);
        $this->signRepository->add($sign);

        $strSplit = explode("\r\n", $data['value']);
        foreach ($strSplit as $item) {
            $signBind = new SignBind();
            $signBind->setSign($sign);
            $signBind->setValue($item);
            $this->signBindRepository->add($signBind);
        }
//        dd($strSplit);
        return [
            'title' => 'Добавление признака',
            'message' => 'Признак ' . $name . ' успешно добавлен!'
        ];
    }

    public function getSignSerialize(): array
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

    public function prepareSignForDelete(): array
    {
        $signs = $this->signRepository->findAll();
        $tmp = [];
        foreach ($signs as $sign) {
            $tmp[] = [
                $sign->getName() => $sign->getId()
            ];
        }
        return $tmp;
    }

    public function deleteSign(int $id): array
    {
        $sign = $this->signRepository->find($id);
        $signBind = $this->signBindRepository->findBy(['sign' => $sign]);
        foreach ($signBind as $item) {
            $genreSignBind = $this->genreSignBindRepository->findBy(['signBind' => $item]);
            foreach ($genreSignBind as $bind) {
                $this->genreSignBindRepository->remove($bind);
            }
            $this->signBindRepository->remove($item, false);
        }
        $this->signBindRepository->flushAll();
        $this->signRepository->remove($sign);
        return [
            'title' => 'Удаление признака',
            'message' => 'Жанр ' . $sign->getName() . ' успешно удален!'
        ];
    }

    public function updateSign(int $id, array $data): array
    {
        //удаляю
        $sign = $this->signRepository->find($id);
        $name = $sign->getName();
        $signBind = $this->signBindRepository->findBy(['sign' => $sign]);
        foreach ($signBind as $item) {
            $genreSignBind = $this->genreSignBindRepository->findBy(['signBind' => $item]);
            foreach ($genreSignBind as $bind) {
                $this->genreSignBindRepository->remove($bind);
            }
            $this->signBindRepository->remove($item, false);
        }
        $this->signBindRepository->flushAll();
        $this->signRepository->remove($sign);
        // добавляю заново
        $sign = new Sign();
        $type = $this->signTypeRepository->find($data['type']);
        $sign->setName($name);
        $sign->setSignType($type);
        $this->signRepository->add($sign);

        $strSplit = explode("\r\n", $data['value']);
        foreach ($strSplit as $item) {
            $signBind = new SignBind();
            $signBind->setSign($sign);
            $signBind->setValue($item);
            $this->signBindRepository->add($signBind);
        }
        return [
            'title' => 'Изменение признака',
            'message' => 'Признак изменен (необходимо изменить жанры)'
        ];
    }

    public function getSignBind(int $id): array
    {
        $sign = $this->signRepository->find($id);
        $signBind = $this->signBindRepository->findBy(['sign' => $sign]);
        $tmp = [];
        foreach ($signBind as $item) {
            $tmp[] = $item->getValue();
        }
        return $tmp;
    }
}