<?php

namespace App\Entity;

use App\Entity\Personne;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\InheritanceType('JOINED')]
#[ORM\DiscriminatorColumn(name:"role",type:"string")]
#[ORM\DiscriminatorMap(["client"=>"Client","gestionnaire"=>"Gestionnaire","livreur"=>"Livreur"])]
class User extends Personne implements UserInterface, PasswordAuthenticatedUserInterface
{

   
    #[Groups(["client:read","gestionnaire:read","livreur:read","commande:read"])]
    #[ORM\Column(type: 'string', length: 180, unique: true)]
    protected $login;

    #[Groups(["client:read","gestionnaire:read","livreur:read","commande:read"])]
    #[ORM\Column(type: 'json')]
    protected $roles = [];

    #[Groups(["client:read","gestionnaire:read","livreur:read"])]
    #[ORM\Column(type: 'string')]
    protected $password;


    public function __construct(){
        $table= get_called_class();
        $table= explode('\\',$table);
        $table = strtoupper($table[2]);
       $this->roles[]= 'ROLE_VISITEUR';
       $this->roles[]= 'ROLE_'.$table;
       
    }
  

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        // $roles[] = "ROLE_VISITEUR";

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;



        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
}
