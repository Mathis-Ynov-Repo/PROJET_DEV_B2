<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;


use App\Dto\RestaurantsOutput;
use App\Entity\Restaurants;

final class RestaurantsOutputDataTransformer implements DataTransformerInterface
{
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return RestaurantsOutput::class === $to && $data instanceof Restaurants;
    }

    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof Restaurants) {
            return;
        }

        $output = new RestaurantsOutput();

        $feedbacks = $object->getFeedback();
        $totalRating = 0;
        $NumberOfRating = count($feedbacks);
        foreach ($feedbacks as $feedback) {
            $totalRating += $feedback->getRating();
        }

        $output->id = $object->getId();
        $output->libelle = $object->getLibelle();
        $output->adresse = $object->getAdresse();
        $output->plats = $object->getPlats();
        $output->type = $object->getType();
        $output->menus = $object->getMenus();
        $output->description = $object->getDescription();
        $output->image = $object->getImage();
        $output->feedback = $feedbacks;
        $output->numberOfRatings = $NumberOfRating;
        $output->created = $object->getCreated();
        if ($NumberOfRating > 0) {
            $output->rating = round($totalRating / $NumberOfRating);
        } else {
            $output->rating = 0;
        }



        return $output;
    }
}
