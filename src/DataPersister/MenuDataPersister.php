<?php

namespace App\DataPersister;

use App\Entity\Menu;
use App\Repository\MenuRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Produit;
use App\Services\Menuservice;

class MenuDataPersister implements ContextAwareDataPersisterInterface
{
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Produit;
    }
    private Menuservice $menu;

    public function __construct(Menuservice $menu, EntityManagerInterface $mananger,MenuRepository $menue)
    {
        $this->menu = $menu;
        $this->menue= $menue;
        $this->mananger = $mananger;
    }

    public function persist($data, array $context = [])
    {
        // call your persistence layer to save $data
       $imm=$this->menue->getImmage();
       $data->setImage($imm);

        $nam=$this->menue->getNamme();
        $data->setNom($nam);

        $prie=$this->menu->prixmenu($data);
    //    dd($prie);
        $data->setPrix($prie);

        $this->mananger->persist($data);
        $this->mananger->flush();
    }

    public function remove($data, array $context = [])
    {
        // call your persistence layer to delete $data
    }
}


