<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BurgerRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["burger:read"]],
    // denormalisationContext: ["groups" => ["burger:write"]]
)]
class Burger extends Produit
{
    #[ORM\OneToMany(mappedBy: 'burger', targetEntity: Menuburger::class)]
    private $menuburgers;




    public function __construct()
    {
        parent::__construct();
        $this->menuburgers = new ArrayCollection();
    }

    /**
     * @return Collection<int, Menuburger>
     */
    public function getMenuburgers(): Collection
    {
        return $this->menuburgers;
    }

    public function addMenuburger(Menuburger $menuburger): self
    {
        if (!$this->menuburgers->contains($menuburger)) {
            $this->menuburgers[] = $menuburger;
            $menuburger->setBurger($this);
        }

        return $this;
    }

    public function removeMenuburger(Menuburger $menuburger): self
    {
        if ($this->menuburgers->removeElement($menuburger)) {
            // set the owning side to null (unless already changed)
            if ($menuburger->getBurger() === $this) {
                $menuburger->setBurger(null);
            }
        }

        return $this;
    }
}
