<?php

namespace App\Entity;

use App\Repository\SoustacheRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SoustacheRepository::class)
 */
class Soustache
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
    private $nomSoutache;

    /**
     * @ORM\Column(type="string")
     */
    private $pourcentageAchever;

    /**
     * @ORM\ManyToOne(targetEntity=Tache::class, inversedBy="soustaches")
     */
    private $taches;

    /**
     * @ORM\ManyToOne(targetEntity=Status::class, inversedBy="soustaches")
     */
    private $statues;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSoutache(): ?string
    {
        return $this->nomSoutache;
    }

    public function setNomSoutache(string $nomSoutache): self
    {
        $this->nomSoutache = $nomSoutache;

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

    public function getTaches(): ?Tache
    {
        return $this->taches;
    }

    public function setTaches(?Tache $taches): self
    {
        $this->taches = $taches;

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


    /**
     * generates a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->nomSoutache;
    }

}
