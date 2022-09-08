<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LignecommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: LignecommandeRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["lignecommande:read", "commande:read"]],
    denormalizationContext: ["groups" => ["lignecommande:write"]],
    itemOperations: ["get"]
)]
class Lignecommande
{

    #[Groups(["lignecommande:read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;


    #[Groups(["commande:read","commande:write","lignecommande:read","lignecommande:write"])]
    #[ORM\Column(type: 'integer', length: 100)]
    private $quantité;

    #[Groups(["commande:read","commande:write","lignecommande:read","lignecommande:write"])]
    #[ORM\ManyToOne(targetEntity: Produit::class, inversedBy: 'lignecommandes')]
    private $produit;

    #[Groups(["lignecommande:read"])]
    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'lignecommandes')]
    private $commandes;


    public function __construct()
    {
        $this->boissontailles = new ArrayCollection();
    }

    // public function __construct()
    // {
    //     $this->commandes = new ArrayCollection();
    // }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantité(): ?string
    {
        return $this->quantité;
    }

    public function setQuantité(string $quantité): self
    {
        $this->quantité = $quantité;

        return $this;
    }



    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->addLignecommande($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeLignecommande($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Boissontaille>
     */
    public function getBoissontailles(): Collection
    {
        return $this->boissontailles;
    }

   
}
