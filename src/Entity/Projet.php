<?php

namespace App\Entity;

use App\Repository\ProjetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProjetRepository::class)
 */
class Projet
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
    private $nomProjet;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateDebutProjet;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $datFinProjet;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateDebutReel;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateFinReel;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $projetComplet;

    /**
     * @ORM\OneToMany(targetEntity=Client::class, mappedBy="projets")
     */
    private $clients;

    /**
     * @ORM\OneToMany(targetEntity=Tache::class, mappedBy="projets")
     */
    private $taches;

    public function __construct()
    {
        $this->clients = new ArrayCollection();
        $this->taches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomProjet(): ?string
    {
        return $this->nomProjet;
    }

    public function setNomProjet(string $nomProjet): self
    {
        $this->nomProjet = $nomProjet;

        return $this;
    }

    public function getDateDebutProjet(): ?\DateTimeInterface
    {
        return $this->dateDebutProjet;
    }

    public function setDateDebutProjet(\DateTimeInterface $dateDebutProjet): self
    {
        $this->dateDebutProjet = $dateDebutProjet;

        return $this;
    }

    public function getDatFinProjet(): ?\DateTimeInterface
    {
        return $this->datFinProjet;
    }

    public function setDatFinProjet(\DateTimeInterface $datFinProjet): self
    {
        $this->datFinProjet = $datFinProjet;

        return $this;
    }

    public function getDateDebutReel(): ?\DateTimeInterface
    {
        return $this->dateDebutReel;
    }

    public function setDateDebutReel(\DateTimeInterface $dateDebutReel): self
    {
        $this->dateDebutReel = $dateDebutReel;

        return $this;
    }

    public function getDateFinReel(): ?\DateTimeInterface
    {
        return $this->dateFinReel;
    }

    public function setDateFinReel(\DateTimeInterface $dateFinReel): self
    {
        $this->dateFinReel = $dateFinReel;

        return $this;
    }

    public function getProjetComplet(): ?bool
    {
        return $this->projetComplet;
    }

    public function setProjetComplet(bool $projetComplet): self
    {
        $this->projetComplet = $projetComplet;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClients(): Collection
    {
        return $this->clients;
    }

    public function addClient(Client $client): self
    {
        if (!$this->clients->contains($client)) {
            $this->clients[] = $client;
            $client->setProjets($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->clients->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getProjets() === $this) {
                $client->setProjets(null);
            }
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
            $tach->setProjets($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): self
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getProjets() === $this) {
                $tach->setProjets(null);
            }
        }

        return $this;
    }

    /**
     * generates a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nomProjet;
    }

}
