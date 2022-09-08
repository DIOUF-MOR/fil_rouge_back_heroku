<?php

namespace App\Entity;

use App\Entity\Burger;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuburgerRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenuburgerRepository::class)]
#[ApiResource(
    normalizationContext:["groups"=>["menuburger:read"]],
    denormalizationContext:["groups"=>["menuburger:write"]]
)]

class Menuburger
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;



    #[Groups(["menuburger:write","menuburger:read","menu:read","menu:write"])]
    #[ORM\ManyToOne(targetEntity: Burger::class, inversedBy: 'menuburgers')]
    private $burger;

 

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menuburgers')]
    private $menu;

    #[Groups(["menuburger:write","menuburger:read","menu:read","menu:write"])]
    #[ORM\Column(type: 'integer')]
    private $qnt;



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



    public function getBurger(): ?Burger
    {
        return $this->burger;
    }

    public function setBurger(?Burger $burger): self
    {
        $this->burger = $burger;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getQnt(): ?int
    {
        return $this->qnt;
    }

    public function setQnt(int $qnt): self
    {
        $this->qnt = $qnt;

        return $this;
    }


}

