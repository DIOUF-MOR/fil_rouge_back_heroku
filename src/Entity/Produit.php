<?php

namespace App\Entity;

use App\Entity\Commande;
use App\Entity\Gestionnaire;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Types\BlobType;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name:"genre",type:"string")]
#[ORM\DiscriminatorMap(["burger"=>"Burger","menu"=>"Menu","boisson"=>"Boisson","frite"=>"Frite"])]
#[ApiResource(
    normalizationContext: ["groups"=>["produit:read","commande:read","taille:read"]]
)]
class Produit 
{
    #[Groups(["burger:read","client:read",'complement:read',"boisson:read",
    "menu:read","frite:read","frite:write","taille:read","menu:read",
     "commande:read","menu:write","catalogue:read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    protected $id;

    #[Groups(["menu:read","client:read","menu:write","burger:read","burger:write",
    'menutaille:read',"boisson:write","boisson:read","frite:write","frite:read",
    "taille:read","catalogue:read",'complement:read'])]
    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    protected $nom;
   
    #[Groups(["boisson:read","frite:read","boisson:write","frite:write",'complement:read',
    "catalogue:read",'menutaille:read',"menu:read","menu:write","burger:read","burger:write",
    "taille:read"])]
    #[ORM\Column(type: 'blob', nullable: true)]
    protected $image;

    // #[Groups(["burger:write","boisson:write","boisson:read","frite:read","catalogue:read"])]
    // #[SerializedName('Images')]
    // protected $faut_image;


    #[Groups(["burger:read",'complement:read',"client:read","burger:write","catalogue:read"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    protected $etat;

    #[Groups(["burger:read","frite:read","menu:read","catalogue:read","boisson:read"])]
    #[ORM\ManyToOne(targetEntity: Gestionnaire::class, inversedBy: 'produits')]
    protected $gestionnaire;

    #[Groups(["burger:read",'complement:read',"boisson:read","taille:read","catalogue:read"])]
    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    protected $description;

    #[Groups(["boisson:read"])]
    #[ORM\OneToMany(mappedBy: 'produit', targetEntity: Lignecommande::class)]
    protected $lignecommandes;


    #[Groups(["catalogue:read","menu:read","menu:write","burger:read",
    'complement:read',"frite:read","boisson:read",
    "taille:read","commande:read","client:read"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $prix;

    #[ORM\Column(type: 'string', length: 100)] 
    #[Groups(["catalogue:read","menu:read","menu:write","burger:read",
    'complement:read',"frite:read","boisson:read",
    "taille:read","commande:read","client:read"])]
    private $type;

  

    public function __construct()
    {
        $this->lignecommandes = new ArrayCollection();
    }

  


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

    


  
    public function getImage(): string
    {
        $result = is_resource($this->image) ? utf8_decode(base64_encode(stream_get_contents($this->image))) : $this->image;
        return $result;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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

    public function getGestionnaire(): ?Gestionnaire
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire(?Gestionnaire $gestionnaire): self
    {
        $this->gestionnaire = $gestionnaire;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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
            $lignecommande->setProduit($this);
        }

        return $this;
    }

    public function removeLignecommande(Lignecommande $lignecommande): self
    {
        if ($this->lignecommandes->removeElement($lignecommande)) {
            // set the owning side to null (unless already changed)
            if ($lignecommande->getProduit() === $this) {
                $lignecommande->setProduit(null);
            }
        }

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(?int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    

}
