<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"commande-plats:details"}},
 * )
 * @ApiFilter(NumericFilter::class, properties={"plat.restaurant.id": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\CommandePlatsRepository")
 */
class CommandePlats extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("commande-plats:details")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups("commande-plats:details")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commandes", inversedBy="commandePlats")
     * @ORM\JoinColumn(nullable=false)
     * @Groups("commande-plats:details")
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plats", inversedBy="commandePlats")
     * @Groups("commande-plats:details")
     */
    private $plat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Menu", inversedBy="commandePlats")
     * @Groups("commande-plats:details")
     */
    private $menu;


    public function getId(): ?int
    {
        return $this->id;
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

    public function getCommande(): ?Commandes
    {
        return $this->commande;
    }

    public function setCommande(?Commandes $commande): self
    {
        $this->commande = $commande;

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

    public function getMenu(): ?Menu
    {
        return $this->menu;
    }

    public function setMenu(?Menu $menu): self
    {
        $this->menu = $menu;

        return $this;
    }


}
