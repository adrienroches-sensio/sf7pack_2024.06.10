<?php

declare(strict_types=1);

namespace App\Serializer\Volunteer;

use App\Entity\Volunteer;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class VolunteerNormalizer implements NormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    /**
     * @param Volunteer $object
     */
    public function normalize(mixed $object, ?string $format = null, array $context = []): array|string|int|float|bool|\ArrayObject|null
    {
        return [
            'id' => $object->getId(),
            'plop' => [
                'event' => $this->normalizer->normalize($object->getEvent(), $format, $context),
                'user' => $this->normalizer->normalize($object->getForUser(), $format, $context),
            ],
        ];
    }

    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        return $data instanceof Volunteer;
    }

    public function getSupportedTypes(?string $format): array
    {
        return [
            Volunteer::class => true,
        ];
    }
}
