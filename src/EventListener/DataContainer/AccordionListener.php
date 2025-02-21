<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\EventListener\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;

#[AsCallback(table: 'tl_content', target: 'config.onpalette')]
class AccordionListener
{
    public function __invoke(string $palette, DataContainer $dc): string
    {
        $currentRecord = $dc->getCurrentRecord();

        if (!$currentRecord || 'tl_content' !== $currentRecord['ptable']) {
            return $palette;
        }

        $parentRecord = $dc->getCurrentRecord($currentRecord['pid'], 'tl_content');

        if (!$parentRecord || 'accordion' !== $parentRecord['type']) {
            return $palette;
        }

        return PaletteManipulator::create()
            ->addField('sectionHeadlineStyle', 'section_legend', PaletteManipulator::POSITION_APPEND)
            ->applyToString($palette)
            ;
    }
}