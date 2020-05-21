<?php

namespace App\Dto;

use Symfony\Component\Serializer\Annotation\Groups;

final class CommandesOutput
{
    /**
     * @Groups({"commande-plats:details", "commandes:details"})
     */
    public $id;
    /**
     * @Groups("commandes:details")
     */
    public $frais;
    /**
     * @Groups({"commande-plats:details", "commandes:details"})
     */
    public $prix;
    /**
     * @Groups("commandes:details")
     */
    public $commandePlats;
    /**
     * @Groups({"commande-plats:details", "commandes:details"})
     */
    public $statut;
    /**
     * @Groups("commandes:details")
     */
    public $dateAchat;
    /**
     * @Groups("commandes:details")
     */
    public $dateReception;
    /**
     * @Groups("commandes:details")
     */
    public $user;
    /**
     * @Groups("commandes:details")
     */
    public $restaurant;
}
