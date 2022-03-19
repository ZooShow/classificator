<?php

namespace App\Entity;

use App\Repository\SignRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SignRepository::class)
 */
class Sign
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=SignType::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $signType;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return SignType
     */
    public function getSignType(): SignType
    {
        return $this->signType;
    }

    public function addSignType(SignType $signType): self
    {
        if (!$this->SignType->contains($signType)) {
            $this->SignType[] = $signType;
            $signType->setSign($this);
        }

        return $this;
    }

    public function removeSignType(SignType $signType): self
    {
        if ($this->SignType->removeElement($signType)) {
            // set the owning side to null (unless already changed)
            if ($signType->getSign() === $this) {
                $signType->setSign(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SignType>
     */
    public function getType(): Collection
    {
        return $this->type;
    }

    public function addType(SignType $type): self
    {
        if (!$this->type->contains($type)) {
            $this->type[] = $type;
            $type->setSign($this);
        }

        return $this;
    }

    public function removeType(SignType $type): self
    {
        if ($this->type->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getSign() === $this) {
                $type->setSign(null);
            }
        }

        return $this;
    }

    public function setSignType(?SignType $signType): self
    {
        $this->signType = $signType;

        return $this;
    }
}
