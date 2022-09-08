<?php

namespace App\Entity;

use App\Repository\BoissonTailleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BoissonTailleRepository::class)]
class BoissonTaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Boisson::class, inversedBy: 'boissonTailles')]
    private $boisson;

    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'boissonTailles')]
    private $taille;

    #[ORM\Column(type: 'integer')]
    private $qnt_stock;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBoisson(): ?Boisson
    {
        return $this->boisson;
    }

    public function setBoisson(?Boisson $boisson): self
    {
        $this->boisson = $boisson;

        return $this;
    }

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

        return $this;
    }

    public function getQntStock(): ?int
    {
        return $this->qnt_stock;
    }

    public function setQntStock(int $qnt_stock): self
    {
        $this->qnt_stock = $qnt_stock;

        return $this;
    }
}
