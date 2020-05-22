<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

final class RestaurantsOutput
{
    /**
     * @Groups({"plats:details", "restaurants:details", "menus:details", "commande-plats:details"})
     */
    public $id;
    /**
     * @Groups({"plats:details", "restaurants:details", "menus:details", "commande-plats:details", "user_read"})
     */
    public $libelle;
    /**
     * @Groups({"plats:details", "restaurants:details"})
     */
    public $adresse;
    /**
     * @Groups({"restaurants:details"})
     */
    public $plats;
    /**
     * @Groups({"restaurants:details"})
     */
    public $type;
    /**
     * @Groups({"restaurants:details"})
     */
    public $menus;
    /**
     * @Groups({"restaurants:details"})
     */
    public $description;
    /**
     * @Groups({"restaurants:details"})
     */
    public $image;
    /**
     * @Groups({"restaurants:details"})
     */
    public $feedback;
    /**
     * @Groups({"restaurants:details"})
     */
    public $rating;
    /**
     * @Groups({"restaurants:details"})
     */
    public $numberOfRatings;
    /**
     * @Groups({"restaurants:details"})
     */
    public $created;
}
