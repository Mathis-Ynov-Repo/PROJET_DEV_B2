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
 *      normalizationContext={"groups"={"commandes:details"}},
 *      collectionOperations={
 *          "get"={"security"="is_granted('ROLE_USER') ", "security_message"="Only logged in users can access this route"},
 *          "post"={"security"="is_granted('ROLE_USER')", "security_message"="Only logged in restaurant owners can access this route"}
 *     },
 *     itemOperations={
 *          "get"={"security"="is_granted('ROLE_USER')", "security_message"="Sorry, but you are not logged in."},
 *          "delete"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Sorry, but you are not the owner of this order."},
 *          "put"={"security_post_denormalize"="is_granted('ROLE_ADMIN') or object.getRestaurant().getUser() == user", 
 *          "security_post_denormalize_message"="Sorry, but you are not the actual order owner."}
 *     }
 * )
 * @ApiFilter(Searchfilter::class, properties={"restaurant": "exact", "statut": "exact", "user": "exact"})
 * @ORM\Entity(repositoryClass="App\Repository\CommandesRepository")
 */
class Commandes extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"commande-plats:details", "commandes:details"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups("commandes:details")
     */
    private $frais;

    /**
     * @ORM\Column(type="float")
     * @Groups({"commande-plats:details", "commandes:details"})
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\CommandePlats", mappedBy="commande")
     * @Groups("commandes:details")
     * 
     */
    private $commandePlats;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"commande-plats:details", "commandes:details"})
     */
    private $statut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("commandes:details")
     */
    private $dateAchat;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("commandes:details")
     */
    private $dateReception;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="commandes")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurants", inversedBy="commandes")
     * @Groups("commandes:details")
     */
    private $restaurant;


    public function __construct()
    {
        $this->commandePlats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFrais(): ?float
    {
        return $this->frais;
    }

    public function setFrais(float $frais): self
    {
        $this->frais = $frais;

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
            $commandePlat->setCommande($this);
        }

        return $this;
    }

    public function removeCommandePlat(CommandePlats $commandePlat): self
    {
        if ($this->commandePlats->contains($commandePlat)) {
            $this->commandePlats->removeElement($commandePlat);
            // set the owning side to null (unless already changed)
            if ($commandePlat->getCommande() === $this) {
                $commandePlat->setCommande(null);
            }
        }

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->dateAchat;
    }

    public function setDateAchat(?\DateTimeInterface $dateAchat): self
    {
        $this->dateAchat = $dateAchat;

        return $this;
    }

    public function getDateReception(): ?\DateTimeInterface
    {
        return $this->dateReception;
    }

    public function setDateReception(?\DateTimeInterface $dateReception): self
    {
        $this->dateReception = $dateReception;

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
