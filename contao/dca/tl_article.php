<?php

use Contao\ArticleModel;
use Contao\CoreBundle\DataContainer\PaletteManipulator;

$table = ArticleModel::getTable();

PaletteManipulator::create()
    ->addLegend('theme_legend', 'template_legend', PaletteManipulator::POSITION_BEFORE)
    ->addField(['backgroundColor', 'containerSize', 'containerSpacing'], 'theme_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('default', $table)
;

$GLOBALS['TL_DCA'][$table]['fields']['backgroundColor'] = [
    'exclude' => true,
    'inputType' => 'select',
    'eval' => [
        'includeBlankOption' => true,
        'tl_class'=> 'w50',
    ],
    'sql' => "varchar(32) default ''"
];

$GLOBALS['TL_DCA'][$table]['fields']['containerSize'] = [
    'exclude' => true,
    'inputType' => 'select',
    'eval' => [
        'includeBlankOption'=>true,
        'tl_class'=>'w50 clr',
    ],
    'sql' => "varchar(32) NOT NULL default ''"
];

$GLOBALS['TL_DCA'][$table]['fields']['containerSpacing'] = [
    'exclude' => true,
    'inputType' => 'select',
    'eval' => [
        'includeBlankOption'=>true,
        'tl_class'=>'w50',
    ],
    'sql' => "varchar(32) NOT NULL default ''"
];