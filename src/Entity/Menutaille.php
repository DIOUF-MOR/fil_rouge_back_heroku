<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenutailleRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenutailleRepository::class)]
#[ApiResource(
    subresourceOperations:[
        'api_menu_menutailles_get_subresource'=>[
            'normalization_context'=>['groups'=>['menutaille:read']]
        ]
        ],
    normalizationContext: ["groups"=>["menutaille:read"]],
    denormalizationContext: ["groups"=>["menutaille:write"]]
)]
class Menutaille
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(["menu:read"])]
    private $id;


    #[ORM\ManyToOne(targetEntity: Menu::class, inversedBy: 'menutailles')]
    private $menu;

    #[Groups(["menutaille:read","menutaille:write","menu:read","menu:write",'menutaille:read'])]
    #[ORM\ManyToOne(targetEntity: Taille::class, inversedBy: 'menutailles')]
    private $taille;

    #[Groups(["menutaille:read","menutaille:write","menu:read","menu:write",'menutaille:read'])]
    #[ORM\Column(type: 'integer')]
    private $qnt;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTaille(): ?Taille
    {
        return $this->taille;
    }

    public function setTaille(?Taille $taille): self
    {
        $this->taille = $taille;

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
