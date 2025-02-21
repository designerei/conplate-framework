<?php

use Contao\ContentModel;
use Contao\CoreBundle\DataContainer\PaletteManipulator;

$table = ContentModel::getTable();

// fields
$GLOBALS['TL_DCA'][$table]['subpalettes']['displayAsButton'] = 'buttonStyle,buttonClass,buttonSize,fullWidth';


// palettes
$GLOBALS['TL_DCA'][$table]['palettes']['__selector__'][] = 'displayAsButton';



$palettes = array_keys($GLOBALS['TL_DCA'][$table]['palettes']);

foreach ($palettes as $palette) {
    if ($palette !== '__selector__') {
        PaletteManipulator::create()
            ->addField('headlineStyle', 'headline')
            ->applyToPalette($palette, $table)
        ;
    }
}

PaletteManipulator::create()
    ->addField('multiSelectable', 'accordion_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('accordion', $table)
;

PaletteManipulator::create()
    ->addField('displayAsButton', 'link_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('hyperlink', 'tl_content')
;

$GLOBALS['TL_DCA'][$table]['palettes']['logo'] = '
    {type_legend},type;
    {template_legend:hide},customTpl;
    {protected_legend:hide},protected;
    {expert_legend:hide},guests,cssID;
    {invisible_legend:hide},invisible,start,stop
';

$GLOBALS['TL_DCA'][$table]['palettes']['copyline'] = '
    {type_legend},type;
    {template_legend:hide},customTpl;
    {protected_legend:hide},protected;
    {expert_legend:hide},guests,cssID;
    {invisible_legend:hide},invisible,start,stop
';

$GLOBALS['TL_DCA'][$table]['palettes']['divider'] = '
    {type_legend},type;
    {template_legend:hide},customTpl;
    {protected_legend:hide},protected;
    {expert_legend:hide},guests,cssID;
    {invisible_legend:hide},invisible,start,stop
';

// fields
$GLOBALS['TL_DCA'][$table]['fields']['headlineStyle'] = [
    'exclude' => true,
    'inputType' => 'select',
    'eval' => [
        'includeBlankOption' => true,
        'tl_class'=> 'w50',
    ],
    'sql' => "varchar(32) default ''"
];

$GLOBALS['TL_DCA'][$table]['fields']['sectionHeadlineStyle'] = [
    'exclude' => true,
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'w50',
        'includeBlankOption' => true,
        'mandatory' => false
    ],
    'sql' => "text NULL"
];

$GLOBALS['TL_DCA'][$table]['fields']['multiSelectable'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'default' => '',
    'eval' => [
        'tl_class'=>'w50'
    ],
    'sql' => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA'][$table]['fields']['buttonClass'] = [
    'inputType' => 'text',
    'eval' => [
        'tl_class' => 'w50'
    ],
    'sql' => "varchar(255) NOT NULL default ''"
];

$GLOBALS['TL_DCA'][$table]['fields']['buttonStyle'] = [
    'inputType' => 'select',
    'default' => '',
    'eval' => [
        'tl_class' => 'w50',
        'includeBlankOption' => true
    ],
    'sql' => "varchar(32) NOT NULL default"
];

$GLOBALS['TL_DCA'][$table]['fields']['buttonSize'] = [
    'inputType' => 'select',
    'default' => '',
    'eval' => [
        'tl_class' => 'w50',
        'includeBlankOption' => true
    ],
    'sql' => "varchar(32) NOT NULL default"
];

$GLOBALS['TL_DCA'][$table]['fields']['displayAsButton'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 clr',
        'submitOnChange' => true
    ],
    'sql' => "char(1) NOT NULL default ''"
];

