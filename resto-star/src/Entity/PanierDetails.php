<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PanierDetailsRepository")
 */
class PanierDetails extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("panier-details:details")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Panier", inversedBy="panierDetails")
     * @Groups("panier-details:details")
     */
    private $panier;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Menu", inversedBy="panierDetails")
     * @Groups("panier-details:details")
     * 
     */
    private $menu;

    /**
     * @ORM\Column(type="integer")
     * @Groups("panier-details:details")
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plats", inversedBy="panierDetails")
     * @Groups("panier-details:details")
     */
    private $plat;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPanier(): ?Panier
    {
        return $this->panier;
    }

    public function setPanier(?Panier $panier): self
    {
        $this->panier = $panier;

        return $this;
    }

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPlat(): ?Plats
    {
        return $this->plat;
    }

    public function setPlat(?Plats $plat): self
    {
        $this->plat = $plat;

        return $this;
    }
}
