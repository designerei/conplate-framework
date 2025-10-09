<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ConplateFrameworkExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('objectToArray', [$this, 'objectToArray'])
        ];
    }

    public function objectToArray(object $value): array
    {
        return json_decode(json_encode($value), true);
    }
}