<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\Constraints as MyAssert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     * @MyAssert\DateVisite
     */
    private $dateVisite;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prixTotal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $numCommande;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Billet", mappedBy="commande", cascade={"persist"})
     * @Assert\Valid()
     */
    private $billets;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbBillets;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $typeVisite;

    public function __construct()
    {
        $this->billets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getDateVisite(): ?\DateTimeInterface
    {
        return $this->dateVisite;
    }

    public function setDateVisite(\DateTimeInterface $dateVisite): self
    {
        $this->dateVisite = $dateVisite;

        return $this;
    }

    public function getPrixTotal(): ?int
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(int $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getNumCommande(): ?string
    {
        return $this->numCommande;
    }

    public function setNumCommande(string $numCommande): self
    {
        $this->numCommande = $numCommande;

        return $this;
    }

    /**
     * @return Collection|Billet[]
     */
    public function getBillets(): Collection
    {
        return $this->billets;
    }

    public function addBillet(Billet $billet): self
    {
        if (!$this->billets->contains($billet)) {
            $this->billets[] = $billet;
            $billet->setCommande($this);
        }

        return $this;
    }

    public function removeBillet(Billet $billet): self
    {
        if ($this->billets->contains($billet)) {
            $this->billets->removeElement($billet);
            // set the owning side to null (unless already changed)
            if ($billet->getCommande() === $this) {
                $billet->setCommande(null);
            }
        }

        return $this;
    }

    public function getNbBillets(): ?int
    {
        return $this->nbBillets;
    }

    public function setNbBillets(int $nbBillets): self
    {
        $this->nbBillets = $nbBillets;

        return $this;
    }

    public function getTypeVisite(): ?string
    {
        return $this->typeVisite;
    }

    public function setTypeVisite(string $typeVisite): self
    {
        $this->typeVisite = $typeVisite;

        return $this;
    }
}
