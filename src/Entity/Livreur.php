<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\LivreurRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreurRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["livreur:read"]],
    // denormalizationContext: ["groups" => ["livreur:write"]]
)]
class Livreur extends User
{
    #[Groups(["livreur:read"])]
    #[ORM\Column(type: 'string', length: 40, nullable: true)]
    private $telephone;

    #[Groups(["livreur:read","livraison:read"])]
    #[ORM\Column(type: 'string', length: 255)]
    private $matricule_moto;

    #[Groups(["livreur:read"])]
    #[ORM\OneToMany(mappedBy: 'livreur', targetEntity: Livraison::class)]
    private $livraisons;

    #[Groups(["livreur:read","livraison:read","livraison:write"])]
    #[ORM\Column(type: 'string', length: 100)]
    private $statut;

    public function __construct()
    {
        $matricule = "MOTO" . Date('dmyhis');
        $this->matricule_moto = $matricule;
        $table = get_called_class();
        $table = explode('\\', $table);
        $table = strtoupper($table[2]);
        $this->roles[] = 'ROLE_VISITEUR';
        $this->roles[] = 'ROLE_' . $table;
        $this->livraisons = new ArrayCollection();
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getMatriculeMoto(): ?string
    {
        return $this->matricule_moto;
    }

    public function setMatriculeMoto(string $matricule_moto): self
    {
        $this->matricule_moto = $matricule_moto;

        return $this;
    }

    /**
     * @return Collection<int, Livraison>
     */
    public function getLivraisons(): Collection
    {
        return $this->livraisons;
    }

    public function addLivraison(Livraison $livraison): self
    {
        if (!$this->livraisons->contains($livraison)) {
            $this->livraisons[] = $livraison;
            $livraison->setLivreur($this);
        }

        return $this;
    }

    public function removeLivraison(Livraison $livraison): self
    {
        if ($this->livraisons->removeElement($livraison)) {
            // set the owning side to null (unless already changed)
            if ($livraison->getLivreur() === $this) {
                $livraison->setLivreur(null);
            }
        }

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
