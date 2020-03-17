<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantTypesRepository")
 */
class RestaurantTypes
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
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Restaurants", mappedBy="type")
     */
    private $restaurants;

    public function __construct()
    {
        $this->restaurants = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Restaurants[]
     */
    public function getRestaurants(): Collection
    {
        return $this->restaurants;
    }

    public function addRestaurant(Restaurants $restaurant): self
    {
        if (!$this->restaurants->contains($restaurant)) {
            $this->restaurants[] = $restaurant;
            $restaurant->setType($this);
        }

        return $this;
    }

    public function removeRestaurant(Restaurants $restaurant): self
    {
        if ($this->restaurants->contains($restaurant)) {
            $this->restaurants->removeElement($restaurant);
            // set the owning side to null (unless already changed)
            if ($restaurant->getType() === $this) {
                $restaurant->setType(null);
            }
        }

        return $this;
    }
}
