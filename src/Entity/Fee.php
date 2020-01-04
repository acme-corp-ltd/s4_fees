<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FeeRepository")
 */
class Fee
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $category;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $limLow;

    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $limTop;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $fee;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getLimLow(): ?string
    {
        return $this->limLow;
    }

    public function setLimLow(string $limLow): self
    {
        $this->limLow = $limLow;

        return $this;
    }

    public function getLimTop(): ?string
    {
        return $this->limTop;
    }

    public function setLimTop(string $limTop): self
    {
        $this->limTop = $limTop;

        return $this;
    }

    public function getFee(): ?string
    {
        return $this->fee;
    }

    public function setFee(string $fee): self
    {
        $this->fee = $fee;

        return $this;
    }
}
