<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"menus:details"}},
 *      collectionOperations={
 *          "get"={"security"="is_granted('ROLE_USER')", "security_message"="Only logged in users can access this route"},
 *          "post"={"security"="is_granted('ROLE_RESTAURATEUR', 'ROLE_ADMIN')", "security_message"="Only logged in restaurant owners can access this route"}
 *      },
 *      itemOperations={
 *          "get"={"security"="is_granted('ROLE_USER')", "security_message"="Sorry, but you are not logged in."},
 *          "delete"={"security"="is_granted('ROLE_ADMIN') or object.getRestaurant().getUser() == user", "security_message"="Sorry, but you are not the owner of this restaurant this dish belongs to."},
 *          "put"={"security_post_denormalize"="is_granted('ROLE_ADMIN') or object.getRestaurant().getUser() == user", 
 *          "security_post_denormalize_message"="Sorry, but you are not the actual restaurant owner this dish belongs to."}
 *      }
 * )
 * @ApiFilter(SearchFilter::class, properties={"restaurant": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\MenuRepository")
 */
class Menu extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"menus:details", "panier-details:details", "commande-plats:details"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"menus:details","panier-details:details", "commande-plats:details"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="float")
     * @Groups({"menus:details","panier-details:details", "commande-plats:details"})
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandePlats", mappedBy="menu")
     */
    private $commandePlats;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\MenuDetails", mappedBy="menu")
     * @Groups({"menus:details","commande-plats:details"})
     */
    private $menuDetails;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurants", inversedBy="menus")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"menus:details", "commande-plats:details"})
     */
    private $restaurant;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PanierDetails", mappedBy="menu")
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
            $panierDetail->setMenu($this);
        }

        return $this;
    }

    public function removePanierDetail(PanierDetails $panierDetail): self
    {
        if ($this->panierDetails->contains($panierDetail)) {
            $this->panierDetails->removeElement($panierDetail);
            // set the owning side to null (unless already changed)
            if ($panierDetail->getMenu() === $this) {
                $panierDetail->setMenu(null);
            }
        }

        return $this;
    }
}
