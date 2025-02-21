<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Contao\StringUtil;

class ConplateFrameworkExtension extends AbstractExtension
{
    public function getFilters(): array
    {
        return [
            new TwigFilter('unserialize', [$this, 'unserialize']),
            new TwigFilter('objectToArray', [$this, 'objectToArray'])
        ];
    }

    public function unserialize($value)
    {
        return is_null($value) ? '' : StringUtil::deserialize($value);
    }

    public function objectToArray(object $value): array
    {
        return json_decode(json_encode($value), true);
    }
}