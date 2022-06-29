<?php

namespace App\Entity;

use App\Repository\PredecesseurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PredecesseurRepository::class)
 */
class Predecesseur
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
    private $nomPredecesseur;

    /**
     * @ORM\ManyToOne(targetEntity=Tache::class, inversedBy="predecesseurs")
     */
    private $taches;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomPredecesseur(): ?string
    {
        return $this->nomPredecesseur;
    }

    public function setNomPredecesseur(string $nomPredecesseur): self
    {
        $this->nomPredecesseur = $nomPredecesseur;

        return $this;
    }

    public function getTaches(): ?Tache
    {
        return $this->taches;
    }

    public function setTaches(?Tache $taches): self
    {
        $this->taches = $taches;

        return $this;
    }

    /**
     * generates a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nomPredecesseur;
    }

}
