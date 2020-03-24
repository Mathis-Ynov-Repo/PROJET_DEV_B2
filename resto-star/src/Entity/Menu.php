<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 */
class Menu extends AbstractEntity
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
    private $libelle;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandePlats", mappedBy="menu")
     */
    private $commandePlats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MenuDetails", mappedBy="menu")
     */
    private $menuDetails;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurants", inversedBy="menus")
     * @ORM\JoinColumn(nullable=false)
     */
    private $restaurant;

    public function __construct()
    {
        $this->commandePlats = new ArrayCollection();
        $this->menuDetails = new ArrayCollection();
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
            $commandePlat->setMenu($this);
        }

        return $this;
    }

    public function removeCommandePlat(CommandePlats $commandePlat): self
    {
        if ($this->commandePlats->contains($commandePlat)) {
            $this->commandePlats->removeElement($commandePlat);
            // set the owning side to null (unless already changed)
            if ($commandePlat->getMenu() === $this) {
                $commandePlat->setMenu(null);
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
            $menuDetail->setMenu($this);
        }

        return $this;
    }

    public function removeMenuDetail(MenuDetails $menuDetail): self
    {
        if ($this->menuDetails->contains($menuDetail)) {
            $this->menuDetails->removeElement($menuDetail);
            // set the owning side to null (unless already changed)
            if ($menuDetail->getMenu() === $this) {
                $menuDetail->setMenu(null);
            }
        }

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
}
