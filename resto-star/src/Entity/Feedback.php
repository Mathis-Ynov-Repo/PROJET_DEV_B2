<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\FeedbackOutput;

/**
 * @ApiResource(
 *      output=FeedbackOutput::class,
 *      collectionOperations={
 *          "get"={"security"="is_granted('ROLE_USER')", "security_message"="Only logged in users can access this route"},
 *          "post"={"security"="is_granted('ROLE_USER')", "security_message"="Only logged in users can access this route"}
 *      },
 *      itemOperations={
 *          "get"={"security"="is_granted('ROLE_USER')", "security_message"="Sorry, but you are not logged in."},
 *          "delete"={"security"="is_granted('ROLE_ADMIN') or object.getUser() == user", "security_message"="Sorry, but you are not the owner of this message."},
 *          "put"={"security_post_denormalize"="is_granted('ROLE_ADMIN') or object.getUser() == user", 
 *          "security_post_denormalize_message"="Sorry, but you are not the actual user this message belongs to."}
 *      }
 * )
 * @ORM\Entity(repositoryClass="App\Repository\FeedbackRepository")
 */
class Feedback extends AbstractEntity
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="feedback")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Restaurants", inversedBy="feedback")
     */
    private $restaurant;

    /**
     * @ORM\Column(type="integer")
     */
    private $rating;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): self
    {
        $this->rating = $rating;

        return $this;
    }
}
