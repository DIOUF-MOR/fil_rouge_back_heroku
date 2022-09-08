<?php

namespace App\Entity\DTO;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DetailRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(
    itemOperations:[
        "get"=>[
         
        ]
    ]
)]
class Detail
{
    private $id;

    #[Groups(["detail:read:menu"])]
    public $menu;

    #[Groups(["detail:read:menu"])]
    public $boissons = [];
    
    #[Groups(["detail:read:menu"])]
    public $frites = [];

    public function __construct(){
        $this->id=1;
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
