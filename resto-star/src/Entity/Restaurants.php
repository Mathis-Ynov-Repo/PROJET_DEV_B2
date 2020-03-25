<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantsRepository")
 */
class Restaurants extends AbstractEntity {
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"plats:details", "restaurants:details", "menus:details"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"plats:details", "restaurants:details", "menus:details"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     * @Groups({"plats:details", "restaurants:details"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="float")
     * @Groups({"restaurants:details"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="float")
     * @Groups({"restaurants:details"})
     */
    private $latitude;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plats", mappedBy="restaurant")
     */
    private $plats;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\RestaurantTypes", inversedBy="restaurants")
     * @Groups({"restaurants:details"})
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Menu", mappedBy="restaurant")
     */
    private $menus;



    public function __construct()
    {
        $this->plats = new ArrayCollection();
        $this->menus = new ArrayCollection();
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

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(float $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(float $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * @return Collection|Plats[]
     */
    public function getPlats(): Collection
    {
        return $this->plats;
    }

    public function addPlat(Plats $plat): self
    {
        if (!$this->plats->contains($plat)) {
            $this->plats[] = $plat;
            $plat->setRestaurant($this);
        }

        return $this;
    }

    public function removePlat(Plats $plat): self
    {
        if ($this->plats->contains($plat)) {
            $this->plats->removeElement($plat);
            // set the owning side to null (unless already changed)
            if ($plat->getRestaurant() === $this) {
                $plat->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getType(): ?RestaurantTypes
    {
        return $this->type;
    }

    public function setType(?RestaurantTypes $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Menu[]
     */
    public function getMenus(): Collection
    {
        return $this->menus;
    }

    public function addMenu(Menu $menu): self
    {
        if (!$this->menus->contains($menu)) {
            $this->menus[] = $menu;
            $menu->setRestaurant($this);
        }

        return $this;
    }

    public function removeMenu(Menu $menu): self
    {
        if ($this->menus->contains($menu)) {
            $this->menus->removeElement($menu);
            // set the owning side to null (unless already changed)
            if ($menu->getRestaurant() === $this) {
                $menu->setRestaurant(null);
            }
        }

        return $this;
    }


}
