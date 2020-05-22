<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

final class FeedbackOutput
{
    /**
     * @Groups({"feedback:details", "restaurants:details"})
     */
    public $id;
    /**
     * @Groups({"feedback:details", "restaurants:details"})
     */
    public $message;
    /**
     * @Groups({"feedback:details", "restaurants:details"})
     */
    public $user;
    /**
     * @Groups({"feedback:details"})
     */
    public $restaurant;
    /**
     * @Groups({"feedback:details", "restaurants:details"})
     */
    public $rating;
    /**
     * @Groups({"feedback:details", "restaurants:details"})
     */
    public $created;
}
