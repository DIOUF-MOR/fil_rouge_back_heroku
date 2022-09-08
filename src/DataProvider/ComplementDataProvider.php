<?php
namespace App\DataProvider;



use App\Repository\FriteRepository;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use Complement;

final class ComplementDataProvider implements ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
//  ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
 {

    public function __construct(FriteRepository $friteRipo, BoissonRepository $boissonRipo){
        $this->friteRipo = $friteRipo;
        $this->boissonRipo = $boissonRipo;
    }

   
    /**
     *
    //  *{@inheritdoc}
     */
    public function getCollection(string $resourceClass, string $operationName = null, array $context = []){
        $complement=[];
        $complement["boisson"] = $this->boissonRipo->findAll();
        $complement["frite"] = $this->friteRipo->findAll();

        return $complement;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool{
        return $resourceClass == Complement::class;
    } 
}



// {@inheritdoc}