<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"platsTypes:details"}} 
 * )
 * @ORM\Entity(repositoryClass="App\Repository\PlatsTypesRepository")
 */
class PlatsTypes
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"plats:details", "platsTypes:details",  "restaurants:details"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"plats:details", "platsTypes:details",  "restaurants:details"})
     */
    private $libelle;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plats", mappedBy="platType")
     */
    private $plats;

    public function __construct()
    {
        $this->plats = new ArrayCollection();
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
            $plat->setPlatType($this);
        }

        return $this;
    }

    public function removePlat(Plats $plat): self
    {
        if ($this->plats->contains($plat)) {
            $this->plats->removeElement($plat);
            // set the owning side to null (unless already changed)
            if ($plat->getPlatType() === $this) {
                $plat->setPlatType(null);
            }
        }

        return $this;
    }
}
