<?php
namespace App\DataProvider;

use App\Entity\Menu;
use App\Entity\Catalogue;
use App\Repository\MenuRepository;
use App\Repository\BurgerRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;

final class CatalogueDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
//  ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
 {

    public function __construct(MenuRepository $menuRipo, BurgerRepository $burgerRipo){
        $this->menuRipo = $menuRipo;
        $this->burgerRipo = $burgerRipo;
        
    }

  
    /**
     *
    //  *{@inheritdoc}:
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []){
        $catalogue=[];
        $catalogue["menu"]= $this->menuRipo->findAll();
        $catalogue["burger"] = $this->burgerRipo->findAll();
        return $catalogue;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool{
        return $resourceClass == Catalogue::class;
    } 
}