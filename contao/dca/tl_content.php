<?php

use Contao\ContentModel;
use Contao\CoreBundle\DataContainer\PaletteManipulator;

$table = ContentModel::getTable();

$palettes = array_keys($GLOBALS['TL_DCA']['tl_content']['palettes']);

foreach ($palettes as $palette) {
    if ($palette !== '__selector__') {
        PaletteManipulator::create()
            ->addField('headlineStyle', 'headline')
            ->applyToPalette($palette, $table)
        ;
    }
}

$GLOBALS['TL_DCA'][$table]['fields']['headlineStyle'] = [
    'exclude' => true,
    'inputType' => 'select',
    'eval' => [
        'includeBlankOption' => true,
        'tl_class'=> 'w50',
    ],
    'sql' => "varchar(32) default ''"
];