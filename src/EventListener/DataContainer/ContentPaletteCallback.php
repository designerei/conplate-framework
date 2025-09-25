<?php

namespace designerei\ConplateFrameworkBundle\EventListener\DataContainer;

use Contao\CoreBundle\DataContainer\Palette;
use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;

#[AsCallback(table: 'tl_content', target: 'config.onpalette')]
class ContentPaletteCallback
{
    public function __invoke(string $palette, DataContainer $dc): string
    {
        $currentRecord = $dc->getCurrentRecord();

        if (null === $currentRecord) {
            return $palette;
        }

        $current_type = $currentRecord['type'];
        $palette = new Palette($palette);

        $palette->addLegend('style_legend', 'expert_legend', 'before');
        $palette->addLegend('layout_child_legend', 'expert_legend', 'before');
        $palette->addLegend('layout_legend', 'expert_legend', 'before');
        $palette->addField('spacing', 'style_legend', 'append');

        if ($palette->hasField('headline')) {
            $palette->addField('headlineStyle', 'style_legend', 'append');
        }

        if ($palette->hasField('sectionHeadline')) {
            $palette->addField('sectionHeadlineStyle', 'section_legend', 'append');
        }

        if ($current_type == 'image') {
            $palette->addField(['responsiveImage', 'aspectRatio', 'figureWidth', 'borderRadius'], 'source_legend', 'append');
        }

        if ($current_type == 'gallery') {
            $palette->removeField(['perRow']);
            $palette->addField(['aspectRatio', 'responsiveImage'], 'image_legend', 'append');
            $palette->addField(['gridTemplateColumns,gap'], 'layout_list_legend', 'append');
        }

        if ($current_type == 'accordion') {
            $palette->addField('multiSelectable', 'accordion_legend', 'append');
        }

        $parentRecord = $dc->getCurrentRecord($currentRecord['pid']);

        if ($parentRecord || $parentRecord['type'] == 'layout') {
            $layout_type = $parentRecord['layoutType'];

            if ($layout_type == 'grid') {
                $palette->addField(['gridColumn', 'gridRow', 'order', 'alignmentSelf'], 'layout_legend', 'append');
            }
            elseif ($layout_type == 'flex')
            {
                $palette->addField(['flexBasis', 'flex', 'flexGrow', 'flexShrink', 'order', 'alignmentSelf'], 'layout_legend', 'append');
            }
            elseif ($layout_type == 'columns')
            {
                $palette->addField(['break'], 'layout_legend', 'append');
            }
        }

        return $palette->toString();
    }
}