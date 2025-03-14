<?php

namespace designerei\ConplateFrameworkBundle\EventListener\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;

#[AsCallback(table: 'tl_content', target: 'config.onpalette')]
class ContentPaletteCallback
{
    public function __invoke(string $palette, DataContainer $dc): string
    {
        $currentRecord = $dc->getCurrentRecord();

        // This shouldn't happen, defensive programming
        if (null === $currentRecord) {
            return $palette;
        }

        // add field headlineStyle if fields headline exists
        if (str_contains($palette, 'headline')) {
             $palette = PaletteManipulator::create()
                ->addField('headlineStyle', 'headline')
                ->applyToString($palette)
            ;
        }

        // add spacing
        $palette = PaletteManipulator::create()
            ->addLegend('layout_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE)
            ->addField('spacing', 'layout_legend', PaletteManipulator::POSITION_APPEND)
            ->applyToString($palette)
        ;

        return $palette;
    }
}