<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @UniqueEntity(fields={"email"}, message="c'est email existe déja")
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Assert\Email(message = " email '{{ value }}' n'est pas correcte email.")
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;


    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $SecondPassword;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nomUser;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $prenomUser;

    /**
     * @ORM\Column(type="integer", length=255, nullable=true)
     */
    private $telUser;
      /**
     * @ORM\Column(type="boolean", nullable=true, nullable=true)
     */
    private $etat;


    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $activation_token;

 

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $roles = [];

    /**
     * @ORM\ManyToMany(targetEntity=Equipe::class, inversedBy="users")
     */
    private $membreEquipe;

    /**
     * @ORM\OneToMany(targetEntity=Equipe::class, mappedBy="chef")
     */
    private $equipes;

    /**
     * @ORM\OneToMany(targetEntity=Membre::class, mappedBy="users")
     */
    private $membres;

    public function __construct()
    {
        $this->membreEquipe = new ArrayCollection();
        $this->equipes = new ArrayCollection();
        $this->membres = new ArrayCollection();
    }

 
    
 



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getemail(): ?string
    {
        return $this->email;
    }

    public function setemail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }


    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        //$roles[] = 'ROLE_USER';
    

       return array_unique($roles);
    }

    public function setRoles(array $roles)
    {
        $this->roles = $roles;

        return $this;
    }

    
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    public function getSecondPassword(): ?string
    {
        return $this->SecondPassword;
    }

    public function setSecondPassword(string $SecondPassword): self
    {
        $this->SecondPassword = $SecondPassword;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string
     *
     * @deprecated since Symfony 5.3, use getUserIdentifier() instead
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
    }

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): self
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenomUser;
    }

    public function setPrenomUser(string $prenomUser): self
    {
        $this->prenomUser = $prenomUser;

        return $this;
    }

    public function getTelUser(): ?string
    {
        return $this->telUser;
    }

    public function setTelUser(string $telUser): self
    {
        $this->telUser = $telUser;

        return $this;
    }

    public function getAdresseUser(): ?string
    {
        return $this->adresseUser;
    }

    public function setAdresseUser(string $adresseUser): self
    {
        $this->adresseUser = $adresseUser;

        return $this;
    }
    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(string $activation_token): self
    {
        $this->activation_token = $activation_token;

        return $this;
    }


    /**
     * generates a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nomUser. ' ' .$this->prenomUser;
    }

    /**
     * @return Collection|Equipe[]
     */
    public function getMembreEquipe(): Collection
    {
        return $this->membreEquipe;
    }

    public function addMembreEquipe(Equipe $membreEquipe): self
    {
        if (!$this->membreEquipe->contains($membreEquipe)) {
            $this->membreEquipe[] = $membreEquipe;
        }

        return $this;
    }

    public function removeMembreEquipe(Equipe $membreEquipe): self
    {
        $this->membreEquipe->removeElement($membreEquipe);

        return $this;
    }

    /**
     * @return Collection|Equipe[]
     */
    public function getEquipes(): Collection
    {
        return $this->equipes;
    }

    public function addEquipe(Equipe $equipe): self
    {
        if (!$this->equipes->contains($equipe)) {
            $this->equipes[] = $equipe;
            $equipe->setChef($this);
        }

        return $this;
    }

    public function removeEquipe(Equipe $equipe): self
    {
        if ($this->equipes->removeElement($equipe)) {
            // set the owning side to null (unless already changed)
            if ($equipe->getChef() === $this) {
                $equipe->setChef(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Membre[]
     */
    public function getMembres(): Collection
    {
        return $this->membres;
    }

    public function addMembre(Membre $membre): self
    {
        if (!$this->membres->contains($membre)) {
            $this->membres[] = $membre;
            $membre->setUsers($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getUsers() === $this) {
                $membre->setUsers(null);
            }
        }

        return $this;
    }


}
