<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      
 * )
 * @ORM\Entity(repositoryClass="App\Repository\MenuDetailsRepository")
 */
class MenuDetails extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"menus:details","commande-plats:details", "restaurants:details"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Menu", inversedBy="menuDetails" ,cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $menu;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plats", inversedBy="menuDetails")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"menus:details","commande-plats:details", "restaurants:details"})
     */
    private $plat;

    public function getId(): ?int
    {
        return $this->id;
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
