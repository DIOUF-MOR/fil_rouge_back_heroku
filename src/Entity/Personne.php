<?php

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\PersonneRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ORM\Entity(repositoryClass: PersonneRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name:"role",type:"string")]
#[ORM\DiscriminatorMap(["user"=>"User","annonyme"=>"Annonyme"])]
class Personne
{
    #[Groups(["client:read","gestionnaire:read","livreur:read","livraison:read","commande:read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    // #[Assert\NotBlank(message:"Ce champ ne peut pas etre vide")]
    #[Groups(["client:read","gestionnaire:read","livreur:read","annonyme:read","livraison:read","commande:read"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    protected $nom;

    #[Groups(["client:read","gestionnaire:read","livreur:read","annonyme:read","livraison:read","commande:read"])]
    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    protected $prenom;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }
}
