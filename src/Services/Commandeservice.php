<?php
namespace App\Services;

use App\Entity\Boisson;
use App\Entity\Boissontaille;
use App\Entity\Commande;
use Symfony\Component\Validator\Constraints\Bic;

class Commandeservice
{

        private $boisson;
    
    public function prixcommande(Commande $commande)
    {
        $montant = 0;
        $lignecommande = $commande->getLignecommandes();
        foreach ($lignecommande as $ligne) {
            $prix = $ligne->getProduit()->getPrix();
            $montant += $prix * $ligne->getQuantité();
        }
        
        $mont = $montant + $commande->getZone()->getPrixLivraison();
        return $mont;
    }
}
