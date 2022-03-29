<?php

namespace App\Entity;

use App\Repository\GenreSignBindRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GenreSignBindRepository::class)
 */
class GenreSignBind
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=SignBind::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $signBind;

    /**
     * @ORM\ManyToOne(targetEntity=Genre::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $genre;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSignBind(): ?SignBind
    {
        return $this->signBind;
    }

    public function setSignBind(?SignBind $signBind): self
    {
        $this->signBind = $signBind;

        return $this;
    }

    public function getGenre(): ?Sign
    {
        return $this->genre;
    }

    public function setGenre(?Genre $genre): self
    {
        $this->genre = $genre;

        return $this;
    }

}
