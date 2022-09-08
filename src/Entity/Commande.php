<?php

namespace App\Entity;

use App\Entity\Zone;
use App\Entity\Produit;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Services\Commandeservice;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: CommandeRepository::class)]
#[ApiResource(

    normalizationContext: ["groups" =>["commande:read"]],
    denormalizationContext: ["groups" =>["commande:write"]]
   
)]
class Commande
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["commande:read", "commande:write", "client:read","livreur:read","livraison:read"])]
    private $id;

    #[ORM\Column(type: 'float', nullable: true)]
    #[Groups(["commande:read", "commande:write", "client:read","livreur:read","livraison:read"])]
    private $montant;

    #[ORM\Column(type: 'datetime', nullable: true)]
    #[Groups(["commande:read", "commande:write", "client:read","livraison:read","livreur:read"])]
    private $date;

    // #[Groups(["commande:read","commande:write"])]
    // #[ORM\Column(type: 'string', length: 50, nullable: true)]
    // private $numeroCommande;


    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'commandes', cascade: ["persist"])]
    #[Groups(["commande:read"])]
    private $gestionnaire;

    #[Groups(["commande:read","client:read"])]
    #[ORM\ManyToOne(targetEntity: Livraison::class, inversedBy: 'commandes', cascade: ["persist"])]
    private $livraison;

    #[ORM\ManyToMany(targetEntity: Lignecommande::class, inversedBy: 'commandes', cascade: ["persist"])]
    #[SerializedName("Produits")]
    #[Groups(["commande:read", "commande:write", "client:read"])]
    private $lignecommandes;



    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    #[Groups(["commande:read", "commande:write","livraison:read","livreur:read","client:read"])]
    private $etat;

    #[ORM\ManyToOne(targetEntity: Zone::class, inversedBy: 'commandes')]
    #[Groups(["commande:read", "commande:write", "client:read","livreur:read","livraison:read"])]
    private $zone;

    #[Groups(["commande:read","livraison:read","livreur:read"])]
    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: 'commandes', cascade: ["persist"])]
    private $client;

    #[Groups(["commande:read","livraison:read","livreur:read"])]
    #[ORM\Column(type: 'string', nullable: true)]
    private $code;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numero;


    public function __construct()
    {
        $this->date=new \DateTime();
        $this->lignecommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }


    // public function getNumeroCommande(): ?string
    // {
    //     return $this->numeroCommande;
    // }

    // public function setNumeroCommande(string $numeroCommande): self
    // {
    //     $this->numeroCommande = $numeroCommande;

    //     return $this;
    // }




    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getLivraison(): ?Livraison
    {
        return $this->livraison;
    }

    public function setLivraison(?Livraison $livraison): self
    {
        $this->livraison = $livraison;

        return $this;
    }



    /**
     * @return Collection<int, Lignecommande>
     */
    public function getLignecommandes(): Collection
    {
        return $this->lignecommandes;
    }

    public function addLignecommande(Lignecommande $lignecommande): self
    {
        if (!$this->lignecommandes->contains($lignecommande)) {
            $this->lignecommandes[] = $lignecommande;
        }

        return $this;
    }

    public function removeLignecommande(Lignecommande $lignecommande): self
    {
        $this->lignecommandes->removeElement($lignecommande);

        return $this;
    }


    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

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

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(?string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }
}
