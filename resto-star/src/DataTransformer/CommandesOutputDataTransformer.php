<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\CommandesOutput;
use App\Entity\Commandes;

final class CommandesOutputDataTransformer implements DataTransformerInterface
{
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return CommandesOutput::class === $to && $data instanceof Commandes;
    }

    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof Commandes) {
            return;
        }

        $output = new CommandesOutput();

        $output->id = $object->getId();
        $output->frais = $object->getFrais();
        $output->prix = $object->getPrix();
        $output->commandePlats = $object->getCommandePlats();
        $output->statut = $object->getStatut();
        if ($object->getDateAchat()) {
            $output->dateAchat = $object->getDateAchat()->format('m/d/Y H:i:s');
        }
        if ($object->getDateReception()) {
            $output->dateReception = $object->getDateReception()->format('m/d/Y H:i:s');
        }
        $output->user = $object->getUser();
        $output->restaurant = $object->getRestaurant();

        return $output;
    }
}
