<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"plats:details"}},
 *      denormalizationContext= {"groups"={"plats:details"}}
 * )
 * @ApiFilter(NumericFilter::class, properties={"restaurant.id": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\PlatsRepository")
 */
class Plats extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"plats:details", "panier-details:details", "commande-plats:details"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"plats:details", "panier-details:details", "commande-plats:details"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="float")
     * @Groups({"plats:details","panier-details:details", "commande-plats:details"})
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurants", inversedBy="plats")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"plats:details","panier-details:details", "commande-plats:details"})
     */
    private $restaurant;



    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandePlats", mappedBy="plat")
     */
    private $commandePlats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MenuDetails", mappedBy="plat")
     */
    private $menuDetails;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PlatsTypes", inversedBy="plats")
     * @Groups("plats:details")
     */
    private $platType;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PanierDetails", mappedBy="plat")
     */
    private $panierDetails;

    public function __construct()
    {
        $this->commandePlats = new ArrayCollection();
        $this->menuDetails = new ArrayCollection();
        $this->paniers = new ArrayCollection();
        $this->panierDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getRestaurant(): ?Restaurants
    {
        return $this->restaurant;
    }

    public function setRestaurant(?Restaurants $restaurant): self
    {
        $this->restaurant = $restaurant;

        return $this;
    }


    /**
     * @return Collection|CommandePlats[]
     */
    public function getCommandePlats(): Collection
    {
        return $this->commandePlats;
    }

    public function addCommandePlat(CommandePlats $commandePlat): self
    {
        if (!$this->commandePlats->contains($commandePlat)) {
            $this->commandePlats[] = $commandePlat;
            $commandePlat->setPlat($this);
        }

        return $this;
    }

    public function removeCommandePlat(CommandePlats $commandePlat): self
    {
        if ($this->commandePlats->contains($commandePlat)) {
            $this->commandePlats->removeElement($commandePlat);
            // set the owning side to null (unless already changed)
            if ($commandePlat->getPlat() === $this) {
                $commandePlat->setPlat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MenuDetails[]
     */
    public function getMenuDetails(): Collection
    {
        return $this->menuDetails;
    }

    public function addMenuDetail(MenuDetails $menuDetail): self
    {
        if (!$this->menuDetails->contains($menuDetail)) {
            $this->menuDetails[] = $menuDetail;
            $menuDetail->setPlat($this);
        }

        return $this;
    }

    public function removeMenuDetail(MenuDetails $menuDetail): self
    {
        if ($this->menuDetails->contains($menuDetail)) {
            $this->menuDetails->removeElement($menuDetail);
            // set the owning side to null (unless already changed)
            if ($menuDetail->getPlat() === $this) {
                $menuDetail->setPlat(null);
            }
        }

        return $this;
    }

    public function getPlatType(): ?PlatsTypes
    {
        return $this->platType;
    }

    public function setPlatType(?PlatsTypes $platType): self
    {
        $this->platType = $platType;

        return $this;
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
            $panierDetail->setPlat($this);
        }

        return $this;
    }

    public function removePanierDetail(PanierDetails $panierDetail): self
    {
        if ($this->panierDetails->contains($panierDetail)) {
            $this->panierDetails->removeElement($panierDetail);
            // set the owning side to null (unless already changed)
            if ($panierDetail->getPlat() === $this) {
                $panierDetail->setPlat(null);
            }
        }

        return $this;
    }
}
