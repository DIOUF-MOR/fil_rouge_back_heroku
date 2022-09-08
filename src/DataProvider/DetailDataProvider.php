<?php
namespace App\DataProvider;



use Complement;
use App\Repository\MenuRepository;
use App\Repository\FriteRepository;
use App\Repository\BoissonRepository;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use ApiPlatform\Core\DataProvider\ContextAwareCollectionDataProviderInterface;
use App\Entity\DTO\Detail;
use App\Entity\Menu;

final class DetailDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
//  ContextAwareCollectionDataProviderInterface, RestrictedDataProviderInterface
 {
    private $menuRepository;
    private $boissonRepository;
    private $friteRepository;
    public function __construct(MenuRepository $menuRepository, BoissonRepository $boissonRepository, FriteRepository $friteRepository){
        $this->menuRepository = $menuRepository;
        $this->boissonRepository = $boissonRepository;
        $this->fritesRepository = $friteRepository;
    }

   


    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool{
        return $resourceClass == Detail::class;
    } 

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        
        $detailMenu = new Detail();
        $detailMenu->menu = $this->menuRepository->find($id);
        $detailMenu->boissons = $this->boissonRepository->findAll();
        $detailMenu->frites = $this->fritesRepository->findAll();
        //dd($detailMenu);
        return $detailMenu;
        // Retrieve the blog post item from somewhere then return it or null if not found
    }
}




// {@inheritdoc}