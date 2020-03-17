<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandePlatsRepository")
 */
class CommandePlats
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $prix;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Commandes", inversedBy="commandePlats")
     * @ORM\JoinColumn(nullable=false)
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plats", inversedBy="commandePlats")
     */
    private $plat;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Menu", inversedBy="commandePlats")
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
