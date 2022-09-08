<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenufriteRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenufriteRepository::class)]
#[ApiResource(
    normalizationContext: ["groups"=>["menufrite:read"]],
    denormalizationContext: ["groups"=>["menufrite:write"]]
)]
class Menufrite
{
    #[Groups(["menufrite:read","menufrite:write","menu:read","menu:write"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

  

    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menufrites')]
    private $menu;

    #[Groups(["menufrite:read","menufrite:write","menu:read","menu:write"])]
    #[ORM\ManyToOne(targetEntity: Frite::class, inversedBy: 'menufrites')]
    private $frite;

    #[Groups(["menufrite:read","menufrite:write","menu:read","menu:write"])]
    #[ORM\Column(type: 'integer')]
    private $qnt;
 


   

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getFrite(): ?Frite
    {
        return $this->frite;
    }

    public function setFrite(?Frite $frite): self
    {
        $this->frite = $frite;

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
}
