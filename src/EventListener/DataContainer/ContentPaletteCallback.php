<?php

namespace designerei\ConplateFrameworkBundle\EventListener\DataContainer;

use Contao\CoreBundle\DataContainer\PaletteManipulator;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Contao\StringUtil;

#[AsCallback(table: 'tl_content', target: 'config.onpalette', priority: -10)]
class ContentPaletteCallback
{
    public function __invoke(string $palette, DataContainer $dc): string
    {
        $currentRecord = $dc->getCurrentRecord();

        if (null === $currentRecord) {
            return $palette;
        }

        if ($this->hasField($palette, 'headline')) {
            $palette = PaletteManipulator::create()
                ->addLegend('style_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE)
                ->addField('headlineStyle', 'style_legend', PaletteManipulator::POSITION_APPEND)
                ->applyToString($palette)
            ;
        }

        if ($this->hasField($palette, 'sectionHeadline')) {
            $palette = PaletteManipulator::create()
                ->addField('sectionHeadlineStyle', 'section_legend', PaletteManipulator::POSITION_APPEND)
                ->applyToString($palette)
            ;
        }

        if ($currentRecord['type'] == 'image') {
            $palette = PaletteManipulator::create()
                ->addField(['responsiveImage', 'aspectRatio', 'figureWidth', 'borderRadius'], 'source_legend', PaletteManipulator::POSITION_APPEND)
                ->applyToString($palette)
            ;
        }

        if ($currentRecord['type'] == 'gallery') {
            $palette = PaletteManipulator::create()
                ->removeField(['perRow'])
                ->addLegend('layout_list_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE)
                ->addField(['aspectRatio', 'responsiveImage'], 'image_legend', PaletteManipulator::POSITION_APPEND)
                ->addField(['gridTemplateColumns,gap'], 'layout_list_legend', PaletteManipulator::POSITION_APPEND)
                ->applyToString($palette)
            ;
        }

        if ($currentRecord['type'] == 'accordion') {
            $palette = PaletteManipulator::create()
                ->addField(['multiSelectable'], 'accordion_legend', PaletteManipulator::POSITION_APPEND)
                ->applyToString($palette)
            ;
        }

        return $palette;
    }

    protected function hasField(string|array $palette, string $field): bool
    {
        $paletteStr = is_array($palette) ? (string) reset($palette) : (string) $palette;
        $fields = StringUtil::trimsplit('[,;]', $paletteStr);

        return in_array($field, $fields, true);
    }
}