<?php

namespace designerei\ConplateFrameworkBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;
use designerei\ConplateFrameworkBundle\ConplateFrameworkBundle;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser): array
    {
        return [
            BundleConfig::create(ConplateFrameworkBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class]),
        ];
    }
}