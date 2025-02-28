<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\EventListener\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;

#[AsCallback(table: 'tl_content', target: 'config.onpalette')]
class LayoutListener
{
    public function __invoke(string $palette, DataContainer $dc): string
    {
        $currentRecord = $dc->getCurrentRecord();

        if (!$currentRecord || 'tl_content' !== $currentRecord['ptable']) {
            return $palette;
        }

        $parentRecord = $dc->getCurrentRecord($currentRecord['pid'], 'tl_content');

        if (!$parentRecord || 'layout' !== $parentRecord['type']) {
            return $palette;
        }

        if ($parentRecord['layoutType'] == 'grid') {
            return PaletteManipulator::create()
                ->addField(['gridColumn', 'gridRow', 'order', 'alignmentSelf'], 'layout_legend', PaletteManipulator::POSITION_PREPEND)
                ->applyToString($palette)
            ;
        } elseif ($parentRecord['layoutType'] == 'flex') {
            return PaletteManipulator::create()
                ->addField(['flexBasis', 'flex', 'flexGrow', 'flexShrink', 'order', 'alignmentSelf'], 'layout_legend', PaletteManipulator::POSITION_PREPEND)
                ->applyToString($palette)
                ;
        }

        return $palette;
    }
}