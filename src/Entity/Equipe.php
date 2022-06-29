<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 */
class Equipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomEquipe;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $emplacement;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $isExternal;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="membreEquipe")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=Tache::class, mappedBy="equipes")
     */
    private $taches;

    /**
     * @ORM\Column(type="integer")
     */
    private $idChefEquipe;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="equipes")
     */
    private $chef;

    /**
     * @ORM\OneToMany(targetEntity=Membre::class, mappedBy="equipes")
     */
    private $membres;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->taches = new ArrayCollection();
        $this->membres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomEquipe(): ?string
    {
        return $this->nomEquipe;
    }

    public function setNomEquipe(string $nomEquipe): self
    {
        $this->nomEquipe = $nomEquipe;

        return $this;
    }

    public function getEmplacement(): ?string
    {
        return $this->emplacement;
    }

    public function setEmplacement(string $emplacement): self
    {
        $this->emplacement = $emplacement;

        return $this;
    }

    public function getIsExternal(): ?bool
    {
        return $this->isExternal;
    }

    public function setIsExternal(bool $isExternal): self
    {
        $this->isExternal = $isExternal;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addMembreEquipe($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeMembreEquipe($this);
        }

        return $this;
    }

    /**
     * @return Collection|Tache[]
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTach(Tache $tach): self
    {
        if (!$this->taches->contains($tach)) {
            $this->taches[] = $tach;
            $tach->setEquipes($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): self
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getEquipes() === $this) {
                $tach->setEquipes(null);
            }
        }

        return $this;
    }

    public function getIdChefEquipe(): ?int
    {
        return $this->idChefEquipe;
    }

    public function setIdChefEquipe(int $idChefEquipe): self
    {
        $this->idChefEquipe = $idChefEquipe;

        return $this;
    }

    /**
     * generates a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nomEquipe;
    }

    public function getChef(): ?User
    {
        return $this->chef;
    }

    public function setChef(?User $chef): self
    {
        $this->chef = $chef;

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
            $membre->setEquipes($this);
        }

        return $this;
    }

    public function removeMembre(Membre $membre): self
    {
        if ($this->membres->removeElement($membre)) {
            // set the owning side to null (unless already changed)
            if ($membre->getEquipes() === $this) {
                $membre->setEquipes(null);
            }
        }

        return $this;
    }

}
