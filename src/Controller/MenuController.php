<?php
namespace App\Controller;

use App\Entity\Menu;
use Doctrine\ORM\EntityManager;
use App\Repository\BurgerRepository;
use App\Repository\FriteRepository;
use App\Repository\TailleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MenuController extends AbstractController {

    public function __invoke(Request $request,EntityManagerInterface $mananger,BurgerRepository $brger,FriteRepository $frit,TailleRepository $tll)
    {
         $content=json_decode($request->getContent());
        //  dd($content);
         if ($content->nom=="") {
            //  dd($content);
             return $this->json("ok",400);
         }
         if ($content->image=="") {
            return $this->json("okffff",400);
         }
         $menu=new Menu();
         $menu->setImage($content->image);
         $menu->setNom($content->nom);
        //  dd($menu);
         foreach ($content->Burgers as $mbrg){
            $burg=$brger->find($mbrg->burger);
            if ($burg) {
               $menu->addBurger($burg,$mbrg->qnt);
            }
         }
         foreach ($content->Frites as $fr) {
            $frie=$frit->find($fr->frite);
            // dd( $fr);
            if ($frie) {
               $menu->addFrite($frie,$fr->qnt);
            }
         }
         foreach ($content->Boissons as $tail) {
            $taille=$tll->find($tail->taille);
            if ($taille) {
              $menu->addTaille($taille,$tail->qnt);
            }
         }
         $mananger->persist($menu);
         $mananger->flush();
         return $this->json("Succes" ,201);
    }
}