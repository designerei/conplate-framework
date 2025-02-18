
<?php

use Contao\CoreBundle\DataContainer\PaletteManipulator;

$GLOBALS['TL_DCA']['tl_page']['fields']['copyline'] = [
    'exclude' => true,
    'inputType' => 'text',
    'eval' => array('tl_class'=>'w50'),
    'sql' => "varchar(255) NOT NULL default ''"
];

PaletteManipulator::create()
    ->addField('copyline', 'global_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('root', 'tl_page')
    ->applyToPalette('rootfallback', 'tl_page')
;