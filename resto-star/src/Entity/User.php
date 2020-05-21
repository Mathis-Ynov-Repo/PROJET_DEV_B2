<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *      normalizationContext={"groups"={"user_read"}},
 *      collectionOperations={
 *          "get"={"security"="is_granted('ROLE_ADMIN')", "security_message"="Only admins can see users."},
 *          "post"
 *     },
 *     itemOperations={
 *          "get"={"security"="is_granted('ROLE_ADMIN') or object == user", "security_message"="Sorry, but you are not the user."},
 *          "delete"={"security"="is_granted('ROLE_ADMIN') or object == user", "security_message"="Sorry, but you are not the user."},
 *          "put"={"security_post_denormalize"="is_granted('ROLE_ADMIN') or object == user", 
 *          "security_post_denormalize_message"="Sorry, but you are not the actual book owner."}
 *     }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("user_read")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(
     *      message = "This email is not a valid email."
     * )
     * @Assert\NotBlank
     * @Groups({"user_read", "commandes:details"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups("user_read")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Your password must be at least {{ limit }} characters long",
     *      allowEmptyString = false
     * )
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commandes", mappedBy="user")
     */
    private $commandes;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups("user_read")
     */
    private $lastConnection;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user_read")
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user_read")
     * @Assert\NotBlank
     */
    private $surname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Feedback", mappedBy="user")
     */
    private $feedback;

    /**
     * @var Image|null
     *
     * @ORM\ManyToOne(targetEntity=Image::class)
     * @Groups("user_read")
     * @ORM\JoinColumn(nullable=true)
     */
    public $image;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"user_read", "commandes:details"})
     */
    private $adress;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups("user_read")
     * @Assert\Type("float")
     */
    private $balance;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Plats", mappedBy="likes")
     * @Groups("user_read")
     */
    private $plats;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->feedback = new ArrayCollection();
        $this->plats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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
            $commande->setUser($this);
        }

        return $this;
    }

    public function removeCommande(Commandes $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getUser() === $this) {
                $commande->setUser(null);
            }
        }

        return $this;
    }

    public function getLastConnection(): ?\DateTimeInterface
    {
        return $this->lastConnection;
    }

    public function setLastConnection(?\DateTimeInterface $lastConnection): self
    {
        $this->lastConnection = $lastConnection;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return Collection|Feedback[]
     */
    public function getFeedback(): Collection
    {
        return $this->feedback;
    }

    public function addFeedback(Feedback $feedback): self
    {
        if (!$this->feedback->contains($feedback)) {
            $this->feedback[] = $feedback;
            $feedback->setUser($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): self
    {
        if ($this->feedback->contains($feedback)) {
            $this->feedback->removeElement($feedback);
            // set the owning side to null (unless already changed)
            if ($feedback->getUser() === $this) {
                $feedback->setUser(null);
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

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(?string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

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
            $plat->addLike($this);
        }

        return $this;
    }

    public function removePlat(Plats $plat): self
    {
        if ($this->plats->contains($plat)) {
            $this->plats->removeElement($plat);
            $plat->removeLike($this);
        }

        return $this;
    }
}
