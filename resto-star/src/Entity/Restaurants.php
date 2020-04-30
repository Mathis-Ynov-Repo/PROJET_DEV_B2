<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"restaurants:details"}},
 *      collectionOperations={
 *          "get"={"security"="is_granted('ROLE_USER')", "security_message"="Only logged in users can access this route"},
 *          "post"={"security"="is_granted('ROLE_RESTAURATEUR') or is_granted('ROLE_ADMIN')", "security_message"="Only logged in restaurant owners can access this route"}
 *     },
 *     itemOperations={
 *          "get"={"security"="is_granted('ROLE_USER')", "security_message"="Sorry, but you are not logged in."},
 *          "delete"={"security"="is_granted('ROLE_ADMIN') or object.getUser() == user", "security_message"="Sorry, but you are not the owner of this restaurant."},
 *          "put"={"security_post_denormalize"="is_granted('ROLE_ADMIN') or object.getUser() == user", 
 *          "security_post_denormalize_message"="Sorry, but you are not the actual restaurant owner."}
 *     }
 * )
 * @ApiFilter(NumericFilter::class, properties={"user.id": "exact"})
 * @ApiFilter(SearchFilter::class, properties={"type.type":"exact"})
 * @ORM\Entity(repositoryClass="App\Repository\RestaurantsRepository")
 */
class Restaurants extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"plats:details", "restaurants:details", "menus:details", "panier-details:details", "commande-plats:details"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"plats:details", "restaurants:details", "menus:details", "panier-details:details", "commande-plats:details", "user_read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="text")
     * @Groups({"plats:details", "restaurants:details"})
     */
    private $adresse;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"restaurants:details"})
     */
    private $longitude;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"restaurants:details"})
     */
    private $latitude;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Plats", mappedBy="restaurant")
     * @Groups({"restaurants:details"})
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

    /**
     * @ORM\Column(type="integer")
     * @Groups({"restaurants:details"})
     */
    private $rating = 0;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"restaurants:details"})
     */
    private $description;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commandes", mappedBy="restaurant")
     */
    private $commandes;

    /**
     * @var Image|null
     *
     * @ORM\ManyToOne(targetEntity=Image::class)
     * @Groups({"restaurants:details"})
     * @ORM\JoinColumn(nullable=true)
     */
    public $image;



    public function __construct()
    {
        $this->plats = new ArrayCollection();
        $this->menus = new ArrayCollection();
        $this->commandes = new ArrayCollection();
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

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Commandes[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commandes $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setRestaurant($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getRestaurant() === $this) {
                $commande->setRestaurant(null);
            }
        }

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;

        return $this;
    }
}
