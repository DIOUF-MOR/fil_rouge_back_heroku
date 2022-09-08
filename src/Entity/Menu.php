<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MenuRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Controller\MenuController;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: MenuRepository::class)]
#[ApiResource(
    subresourceOperations:[
        'menu_get_subresource'=>[
            'metode'=>'GET',
            'path'=>'/menu/{id}/menutailles'
        ]
        ],
    normalizationContext: ["groups" => ["menu:read"]],
    denormalizationContext: ["groups" => ["menu:write"]],

)]
class Menu extends Produit
{
    // #[ORM\Column(type: 'string', length: 50)]
    // protected string $nommme;

    #[Groups(["menu:read", "menu:write"])]
    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    #[SerializedName("nom")]
    private $namme;
    
    #[Groups(["boisson:read", "menu:read", "frite:read", "menu:write"])]
    #[SerializedName("image")]
    protected $immage;
    
    #[Groups(["menu:read", "menu:write"])]
    #[ORM\Column(type: 'integer')]
    #[SerializedName("prix")]
    private $price;

    #[Groups(["menu:read", "menu:write"])]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Menutaille::class, cascade:["persist"])]
    #[SerializedName("boissons")]
    #[Apisubresource()]
    protected $menutailles;


    #[Groups(["menu:read", "menu:write"])]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Menufrite::class, cascade:["persist"])]
    #[SerializedName("frites")]
    protected $menufrites;


    #[Groups(["menu:read", "menu:write"])]
    #[ORM\OneToMany(mappedBy: 'menu', targetEntity: Menuburger::class, cascade:["persist"])]
    #[SerializedName("burgers")]
    private $menuburgers;


    public function __construct()
    {
        parent::__construct();
        $this->menutailles = new ArrayCollection();
        $this->menufrites = new ArrayCollection();
        $this->menuburgers = new ArrayCollection();
    }

    public function addBurger(Burger $burger, int $qnt)
    {
        $newburger = new Menuburger();

        $newburger->setBurger($burger);
        $newburger->setQnt($qnt);
        $newburger->setMenu($this);

        $this->addMenuburger($newburger);
    }

    public function addFrite(Frite $frite, int $qnt)
    {
        $newfrite = new Menufrite();

        $newfrite->setFrite($frite);
        $newfrite->setQnt($qnt);
        $newfrite->setMenu($this);

        $this->addMenufrite($newfrite);
    }

    public function addTaille(Taille $taille, int $qnt)
    {
        $newtaille = new Menutaille();

        $newtaille->setTaille($taille);
        $newtaille->setQnt($qnt);
        $newtaille->setMenu($this);

        $this->addMenutaille($newtaille);
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
            $menutaille->setMenu($this);
        }

        return $this;
    }

    public function removeMenutaille(Menutaille $menutaille): self
    {
        if ($this->menutailles->removeElement($menutaille)) {
            // set the owning side to null (unless already changed)
            if ($menutaille->getMenu() === $this) {
                $menutaille->setMenu(null);
            }
        }

        return $this;
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
            $menufrite->setMenu($this);
        }

        return $this;
    }

    public function removeMenufrite(Menufrite $menufrite): self
    {
        if ($this->menufrites->removeElement($menufrite)) {
            // set the owning side to null (unless already changed)
            if ($menufrite->getMenu() === $this) {
                $menufrite->setMenu(null);
            }
        }

        return $this;
    }



    public function getNamme(): ?string
    {
        return $this->namme;
    }

    public function setNamme(string $namme): self
    {
        $this->namme = $namme;

        return $this;
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
            $menuburger->setMenu($this);
        }

        return $this;
    }

    public function removeMenuburger(Menuburger $menuburger): self
    {
        if ($this->menuburgers->removeElement($menuburger)) {
            // set the owning side to null (unless already changed)
            if ($menuburger->getMenu() === $this) {
                $menuburger->setMenu(null);
            }
        }

        return $this;
    }

    /**
     * Get the value of immage
     */ 
    public function getImmage()
    {
        return $this->immage;
    }

    /**
     * Set the value of immage
     *
     * @return  self
     */ 
    public function setImmage($immage)
    {
        $this->immage = $immage;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }
   


}
