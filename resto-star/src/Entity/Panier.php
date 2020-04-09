<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"panier:details"}},
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PanierRepository")
 */
class Panier extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"panier:details", "panier-details:details"})
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PanierDetails", mappedBy="panier")
     */
    private $panierDetails;

    /**
     * @ORM\Column(type="integer")
     */
    private $user;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"panier:details", "panier-details:details"})
     */
    private $prix;

    public function __construct()
    {
        $this->panierDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection|PanierDetails[]
     */
    public function getPanierDetails(): Collection
    {
        return $this->panierDetails;
    }

    public function addPanierDetail(PanierDetails $panierDetail): self
    {
        if (!$this->panierDetails->contains($panierDetail)) {
            $this->panierDetails[] = $panierDetail;
            $panierDetail->setPanier($this);
        }

        return $this;
    }

    public function removePanierDetail(PanierDetails $panierDetail): self
    {
        if ($this->panierDetails->contains($panierDetail)) {
            $this->panierDetails->removeElement($panierDetail);
            // set the owning side to null (unless already changed)
            if ($panierDetail->getPanier() === $this) {
                $panierDetail->setPanier(null);
            }
        }

        return $this;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
}
