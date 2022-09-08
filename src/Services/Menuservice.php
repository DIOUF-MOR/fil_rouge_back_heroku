<?php

namespace App\Services;

use App\Entity\Menu;

class Menuservice
{

    public function prixmenu(Menu $menu)
    {
        $prix = 0;
        $burgers = $menu->getMenuburgers();
        foreach ($burgers as $burg) {

            $br = $burg->getBurger();
            $prix += $br->getPrix() * $burg->getQnt();
        }
        $taille = $menu->getMenutailles();
        foreach ($taille as $tail) {

            $ta = $tail->getTaille();
            $prix += $ta->getPrix() * $tail->getQnt();
        }
        $frite = $menu->getMenufrites();
        foreach ($frite as $frt) {

            $frte = $frt->getFrite();

            $prix += $frte->getPrix() * $frt->getQnt();
        }
       
        // dd($prix);


        return $prix;
    }

    
}
