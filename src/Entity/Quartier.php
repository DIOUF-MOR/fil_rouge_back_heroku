<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\QuartierRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: QuartierRepository::class)]
#[ApiResource(
    normalizationContext: ["groups"=>["quartier:read"]]
)]
class Quartier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["quartier:read"])]
    #[ORM\Column(type: 'string', length: 30)]
    private $nom;

    #[Groups(["quartier:read"])]
    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'quartiers')]
    #[ORM\JoinColumn(nullable: false)]
    private $zone;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'quartiers')]
    private $gestionnaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->zone;
    }

    public function setZone(?Zone $zone): self
    {
        $this->zone = $zone;

        return $this;
    }

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }
}
