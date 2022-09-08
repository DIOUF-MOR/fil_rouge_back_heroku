<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TailleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: TailleRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["taille:read"]],
    // denormalizationContext:["groups"=>["taille:read","menu:write"]]
)]
class Taille
{
    #[Groups(["taille:read","menu:read"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Groups(["menu:read", 'menutaille:read', 'menutaille:write', "menu:write", "taille:read", "taille:write", "menutaille:read", "menutaille:write"])]
    #[ORM\Column(type: 'string', length: 50)]
    private $libelle;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: Menutaille::class, cascade:["persist"])]
    private $menutailles;

    #[Groups(["taille:read", 'menutaille:read', 'menutaille:write', "taille:write", "menu:read", "menu:write", "commande:read", "menutaille:read", "menutaille:write"])]
    #[ORM\Column(type: 'integer', nullable: true)]
    private $prix;

    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: Boisson::class)]
    private $boissons;

    #[Groups(["taille:read", 'menutaille:read', "menu:read"])]
    #[ORM\OneToMany(mappedBy: 'taille', targetEntity: BoissonTaille::class)]
    private $boissonTailles;

   

    public function __construct()
    {
        $this->menutailles = new ArrayCollection();
        $this->boissons = new ArrayCollection();
        $this->boissonTailles = new ArrayCollection();
    }


    /**
     * Get the value of libelle
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set the value of libelle
     *
     * @return  self
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return Collection<int, Menutaille>
     */
    public function getMenutailles(): Collection
    {
        return $this->menutailles;
    }

    public function addMenutaille(Menutaille $menutaille): self
    {
        if (!$this->menutailles->contains($menutaille)) {
            $this->menutailles[] = $menutaille;
            $menutaille->setTaille($this);
        }

        return $this;
    }

    public function removeMenutaille(Menutaille $menutaille): self
    {
        if ($this->menutailles->removeElement($menutaille)) {
            // set the owning side to null (unless already changed)
            if ($menutaille->getTaille() === $this) {
                $menutaille->setTaille(null);
            }
        }

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * @return Collection<int, Boisson>
     */
    public function getBoissons(): Collection
    {
        return $this->boissons;
    }

    public function addBoisson(Boisson $boisson): self
    {
        if (!$this->boissons->contains($boisson)) {
            $this->boissons[] = $boisson;
            $boisson->setTaille($this);
        }

        return $this;
    }

    public function removeBoisson(Boisson $boisson): self
    {
        if ($this->boissons->removeElement($boisson)) {
            // set the owning side to null (unless already changed)
            if ($boisson->getTaille() === $this) {
                $boisson->setTaille(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, BoissonTaille>
     */
    public function getBoissonTailles(): Collection
    {
        return $this->boissonTailles;
    }

    public function addBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if (!$this->boissonTailles->contains($boissonTaille)) {
            $this->boissonTailles[] = $boissonTaille;
            $boissonTaille->setTaille($this);
        }

        return $this;
    }

    public function removeBoissonTaille(BoissonTaille $boissonTaille): self
    {
        if ($this->boissonTailles->removeElement($boissonTaille)) {
            // set the owning side to null (unless already changed)
            if ($boissonTaille->getTaille() === $this) {
                $boissonTaille->setTaille(null);
            }
        }

        return $this;
    }

  
  
}
