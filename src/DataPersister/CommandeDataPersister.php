<?php

namespace App\DataPersister;

// use ApiPlatform\Core\Bridge\Symfony\Bundle\Test\Response;

use App\Entity\Frite;
use App\Entity\Boisson;
use App\Entity\Livreur;
use App\Entity\Commande;
use App\Entity\Livraison;
use PhpParser\Node\Stmt\Else_;
use App\Services\Commandeservice;
use App\Repository\ClientRepository;
use App\Repository\BoissonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;

class CommandeDataPersister implements ContextAwareDataPersisterInterface
{

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Commande or $data instanceof Livraison ;
    }


    public function __construct(Commandeservice $commande, EntityManagerInterface $mananger, private ClientRepository $clientripo)
    {
        $this->mananger = $mananger;
        $this->commande = $commande;
    }


    public function persist($data, array $context = [])
    {

        if ($data instanceof Commande) {
            $nbrComplement = 0;
            $lignes = $data->getLignecommandes();
            foreach ($lignes as $ligne) {
                if ($ligne->getProduit() instanceof Boisson or $ligne->getProduit() instanceof Frite) {
                    $nbrComplement++;
                }
            }
            if ($nbrComplement === count($lignes)) {
                return new JsonResponse(['Error' => 'Impossible de commander uniquement les complements'], Response::HTTP_BAD_REQUEST);
            }

            // $numero='CMD00'+$data->getId()+'C'+$data->getId();
            // $data->setNumero($numero);

            $co=(string)$data->getId();
            $code='CD'.$co;
            $data->setCode($code);

            $montan = $this->commande->prixcommande($data);
            $data->setMontant($montan);
        }

        if ($data instanceof Livraison) {
            $commds = $data->getCommandes();
            $id = 0;
            foreach ($commds as $comd) {
                $id += $comd->getZone()->getId();
                
            }
            if ($id / count($commds) !== $commds[0]->getZone()->getId()) {

                return new JsonResponse(['Error' => 'On livre que les commandses du meme zone'], Response::HTTP_BAD_REQUEST);
            }
            // $data->getLivreur()->setStatut('occupe');
            // $data->setEtat('en cours');

        }
     

        $this->mananger->persist($data);
        $this->mananger->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {
    }
}
