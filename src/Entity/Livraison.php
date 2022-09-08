<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\LivraisonRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivraisonRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["livraison:read"]]
)]
class Livraison
{
    #[Groups(["livraison:read", "livreur:read", "commande:read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["livraison:read", "livreur:read"])]
    #[ORM\OneToMany(mappedBy: 'livraison', targetEntity: Commande::class)]
    private $commandes;

    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'livraisons')]
    private $gestionnaire;

    #[Groups(["livraison:read"])]
    #[ORM\ManyToOne(targetEntity: Livreur::class, inversedBy: 'livraisons')]
    private $livreur;

    #[Groups(["livraison:read", "livreur:read","commande:read"])]
    #[ORM\Column(type: 'datetime')]
    private $date;

    #[Groups(["livraison:read", "livreur:read","commande:read"])]
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private $etat;


    public function __construct()
    {
        
        $this->date = new \DateTime();
        $this->commandes = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $commande->setLivraison($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            // set the owning side to null (unless already changed)
            if ($commande->getLivraison() === $this) {
                $commande->setLivraison(null);
            }
        }

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

    public function getLivreur(): ?Livreur
    {
        return $this->livreur;
    }

    public function setLivreur(?Livreur $livreur): self
    {
        $this->livreur = $livreur;

        return $this;
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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(?string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
