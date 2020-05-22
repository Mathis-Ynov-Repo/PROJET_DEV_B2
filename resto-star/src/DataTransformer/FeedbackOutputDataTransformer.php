<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;

use App\Dto\FeedbackOutput;
use App\Entity\Feedback;

final class FeedbackOutputDataTransformer implements DataTransformerInterface
{
    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return FeedbackOutput::class === $to && $data instanceof Feedback;
    }

    public function transform($object, string $to, array $context = [])
    {
        if (!$object instanceof Feedback) {
            return;
        }

        $output = new FeedbackOutput();

        $output->id = $object->getId();
        $output->message = $object->getMessage();
        $output->user = $object->getUser();
        $output->created = $object->getCreated()->format('m/d/Y H:i:s');
        $output->rating = $object->getRating();
        $output->restaurant = $object->getRestaurant();


        return $output;
    }
}
