<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\FriteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: FriteRepository::class)]
#[ApiResource(
    normalizationContext: ["groups"=>["frite:read","menu:read"]],
    denormalizationContext: ["groups"=>["frite:write"]],
  
)]
class Frite extends Produit
{
    #[ORM\OneToMany(mappedBy: 'frite', targetEntity: Menufrite::class)]
    private $menufrites;

    #[Groups(["frite:read","frite:write"])]
    private $prix;

    public function __construct()
    {
        parent::__construct();
        $this->menufrites = new ArrayCollection();
    }

    /**
     * @return Collection<int, Menufrite>
     */
    public function getMenufrites(): Collection
    {
        return $this->menufrites;
    }

    public function addMenufrite(Menufrite $menufrite): self
    {
        if (!$this->menufrites->contains($menufrite)) {
            $this->menufrites[] = $menufrite;
            $menufrite->setFrite($this);
        }

        return $this;
    }

    public function removeMenufrite(Menufrite $menufrite): self
    {
        if ($this->menufrites->removeElement($menufrite)) {
            // set the owning side to null (unless already changed)
            if ($menufrite->getFrite() === $this) {
                $menufrite->setFrite(null);
            }
        }

        return $this;
    }

   
}
