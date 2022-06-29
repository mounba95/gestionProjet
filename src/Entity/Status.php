<?php

namespace App\Entity;

use App\Repository\StatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatusRepository::class)
 */
class Status
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
    private $nomStatus;

    /**
     * @ORM\OneToMany(targetEntity=Tache::class, mappedBy="statues")
     */
    private $taches;

    /**
     * @ORM\OneToMany(targetEntity=Soustache::class, mappedBy="statues")
     */
    private $soustaches;

    public function __construct()
    {
        $this->taches = new ArrayCollection();
        $this->soustaches = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomStatus(): ?string
    {
        return $this->nomStatus;
    }

    public function setNomStatus(string $nomStatus): self
    {
        $this->nomStatus = $nomStatus;

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
            $tach->setStatues($this);
        }

        return $this;
    }

    public function removeTach(Tache $tach): self
    {
        if ($this->taches->removeElement($tach)) {
            // set the owning side to null (unless already changed)
            if ($tach->getStatues() === $this) {
                $tach->setStatues(null);
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
            $soustach->setStatues($this);
        }

        return $this;
    }

    public function removeSoustach(Soustache $soustach): self
    {
        if ($this->soustaches->removeElement($soustach)) {
            // set the owning side to null (unless already changed)
            if ($soustach->getStatues() === $this) {
                $soustach->setStatues(null);
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
        return $this->nomStatus;
    }

}
