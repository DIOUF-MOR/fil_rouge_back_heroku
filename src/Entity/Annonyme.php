<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AnnonymeRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: AnnonymeRepository::class)]
#[ApiResource(
    normalizationContext: ["groups"=>["annonyme:read"]]
)]
class Annonyme extends Personne 
{
   
}
