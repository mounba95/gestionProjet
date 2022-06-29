<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TacheRepository::class)
 */
class Tache
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
    private $nomTache;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $datePrevueDebut;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $datePrevuFin;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateActuelDebut;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateActuelFin;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $pourcentageAchever;

    /**
     * @ORM\OneToMany(targetEntity=Predecesseur::class, mappedBy="taches")
     */
    private $predecesseurs;

    /**
     * @ORM\OneToMany(targetEntity=Soustache::class, mappedBy="taches")
     */
    private $soustaches;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="taches")
     */
    private $statues;

    /**
     * @ORM\ManyToOne(targetEntity=Equipe::class, inversedBy="taches")
     */
    private $equipes;

    /**
     * @ORM\ManyToOne(targetEntity=Projet::class, inversedBy="taches")
     */
    private $projets;

    public function __construct()
    {
        $this->predecesseurs = new ArrayCollection();
        $this->soustaches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomTache(): ?string
    {
        return $this->nomTache;
    }

    public function setNomTache(string $nomTache): self
    {
        $this->nomTache = $nomTache;

        return $this;
    }

    public function getDatePrevueDebut(): ?\DateTimeInterface
    {
        return $this->datePrevueDebut;
    }

    public function setDatePrevueDebut(\DateTimeInterface $datePrevueDebut): self
    {
        $this->datePrevueDebut = $datePrevueDebut;

        return $this;
    }

    public function getDatePrevuFin(): ?\DateTimeInterface
    {
        return $this->datePrevuFin;
    }

    public function setDatePrevuFin(\DateTimeInterface $datePrevuFin): self
    {
        $this->datePrevuFin = $datePrevuFin;

        return $this;
    }

    public function getDateActuelDebut(): ?\DateTimeInterface
    {
        return $this->dateActuelDebut;
    }

    public function setDateActuelDebut(\DateTimeInterface $dateActuelDebut): self
    {
        $this->dateActuelDebut = $dateActuelDebut;

        return $this;
    }

    public function getDateActuelFin(): ?\DateTimeInterface
    {
        return $this->dateActuelFin;
    }

    public function setDateActuelFin(\DateTimeInterface $dateActuelFin): self
    {
        $this->dateActuelFin = $dateActuelFin;

        return $this;
    }

    public function getPourcentageAchever(): ?string
    {
        return $this->pourcentageAchever;
    }

    public function setPourcentageAchever(string $pourcentageAchever): self
    {
        $this->pourcentageAchever = $pourcentageAchever;

        return $this;
    }

    /**
     * @return Collection|Predecesseur[]
     */
    public function getPredecesseurs(): Collection
    {
        return $this->predecesseurs;
    }

    public function addPredecesseur(Predecesseur $predecesseur): self
    {
        if (!$this->predecesseurs->contains($predecesseur)) {
            $this->predecesseurs[] = $predecesseur;
            $predecesseur->setTaches($this);
        }

        return $this;
    }

    public function removePredecesseur(Predecesseur $predecesseur): self
    {
        if ($this->predecesseurs->removeElement($predecesseur)) {
            // set the owning side to null (unless already changed)
            if ($predecesseur->getTaches() === $this) {
                $predecesseur->setTaches(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Soustache[]
     */
    public function getSoustaches(): Collection
    {
        return $this->soustaches;
    }

    public function addSoustach(Soustache $soustach): self
    {
        if (!$this->soustaches->contains($soustach)) {
            $this->soustaches[] = $soustach;
            $soustach->setTaches($this);
        }

        return $this;
    }

    public function removeSoustach(Soustache $soustach): self
    {
        if ($this->soustaches->removeElement($soustach)) {
            // set the owning side to null (unless already changed)
            if ($soustach->getTaches() === $this) {
                $soustach->setTaches(null);
            }
        }

        return $this;
    }

    public function getStatues(): ?Status
    {
        return $this->statues;
    }

    public function setStatues(?Status $statues): self
    {
        $this->statues = $statues;

        return $this;
    }

    public function getEquipes(): ?Equipe
    {
        return $this->equipes;
    }

    public function setEquipes(?Equipe $equipes): self
    {
        $this->equipes = $equipes;

        return $this;
    }

    public function getProjets(): ?Projet
    {
        return $this->projets;
    }

    public function setProjets(?Projet $projets): self
    {
        $this->projets = $projets;

        return $this;
    }


    /**
     * generates a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nomTache;
    }

}
