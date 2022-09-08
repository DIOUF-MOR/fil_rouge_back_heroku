<?php
namespace App\DataPersister;

use App\Entity\User;
use App\Services\MailerService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\HttpCache\Esi;
use Doctrine\Common\Annotations\Annotation\Enum;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class DataPersister implements ContextAwareDataPersisterInterface{
      /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool{
        return $data instanceof User;
    }

    
    public function __construct(UserPasswordHasherInterface $encoder, EntityManagerInterface $mananger, MailerService $mailerService)
    {
        $this->encoder = $encoder;
        $this->mananger = $mananger;
        $this->mailerService = $mailerService;

    }

    
    public function persist($data, array $context = []){
       
        if($data->getPassword()){
            $hash=$this->encoder->hashPassword($data,$data->getPassword());
            $data->setPassword($hash);
            $this->mananger->persist($data);
            $this->mananger->flush();
            $this->mailerService->sendEmail($data);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = []){

    }
    
}