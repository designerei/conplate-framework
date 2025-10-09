<?php

use Contao\ContentModel;
use Contao\CoreBundle\DataContainer\PaletteManipulator;

$table = ContentModel::getTable();

$GLOBALS['TL_DCA'][$table]['palettes']['__selector__'][] = 'displayAsButton';

$GLOBALS['TL_DCA'][$table]['subpalettes']['displayAsButton'] = 'buttonStyle,buttonSize,fullWidth';

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

$GLOBALS['TL_DCA'][$table]['palettes']['editor_note'] = '
    {type_legend},title,type;
    {text_legend},editorNote;
    {expert_legend:hide},cssID;
    {invisible_legend:hide},invisible,start,stop'
;

$GLOBALS['TL_DCA'][$table]['palettes']['editor_placeholder'] = '
    {type_legend},title,type;
    {layout_legend},aspectRatio;
    {expert_legend:hide},cssID;
    {invisible_legend:hide},invisible,start,stop'
;

PaletteManipulator::create()
    ->removeField('addImage')
    ->applyToPalette('text', $table)
;

PaletteManipulator::create()
    ->removeField('useImage')
    ->applyToPalette('hyperlink', $table)
;

PaletteManipulator::create()
    ->addField('displayAsButton', 'link_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('hyperlink', 'tl_content')
;

$GLOBALS['TL_DCA'][$table]['fields']['headlineStyle'] = [
    'exclude' => true,
    'inputType' => 'select',
    'eval' => [
        'includeBlankOption' => true,
        'tl_class'=> 'w50',
    ],
    'sql' => "varchar(32) default ''"
];

$GLOBALS['TL_DCA'][$table]['fields']['sectionHeadlineStyle'] = $GLOBALS['TL_DCA'][$table]['fields']['headlineStyle'];

$GLOBALS['TL_DCA'][$table]['fields']['multiSelectable'] = [
    'exclude' => true,
    'inputType' => 'checkbox',
    'default' => '',
    'eval' => [
        'tl_class'=>'w50'
    ],
    'sql' => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA'][$table]['fields']['buttonStyle'] = [
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'w50'
    ],
    'sql' => "varchar(32) NOT NULL default ''"
];

$GLOBALS['TL_DCA'][$table]['fields']['buttonSize'] = [
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'w50',
    ],
    'sql' => "varchar(32) NOT NULL default ''"
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

$GLOBALS['TL_DCA'][$table]['fields']['responsiveImage'] = [
    'inputType' => 'checkbox',
    'default'  => '1',
    'eval' => [
        'tl_class'=>'w50 m12'
    ],
    'sql' => "char(1) NOT NULL default '1'"
];

$GLOBALS['TL_DCA'][$table]['fields']['figureWidth'] = [
    'exclude' => true,
    'inputType' => 'inputUnit',
    'options' => ['px', 'rem', 'em', '%'],
    'eval' => [
        'rgxp'=>'digit_auto_inherit',
        'maxlength' => 4,
        'tl_class'=>'w50'
    ],
    'sql' => "varchar(64) NOT NULL default ''"
];

$GLOBALS['TL_DCA'][$table]['fields']['editorNote'] = [
    'exclude' => true,
    'inputType' => 'textarea',
    'eval' => [
        'mandatory' => true,
        'basicEntities'=>true,
        'decodeEntities'=>true,
        'allowHtml'=>true,
    ],
    'sql' => "mediumtext NULL"
];

$GLOBALS['TL_DCA'][$table]['fields']['aspectRatio'] = [
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'w50 w50h autoheight',
        'multiple' => true,
        'size' => '10',
        'chosen' => true,
        'mandatory' => false
    ],
    'sql' => "text NULL"
];

$GLOBALS['TL_DCA'][$table]['fields']['borderRadius'] = [
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'w50 w50h autoheight',
        'multiple' => true,
        'size' => '10',
        'chosen' => true,
        'mandatory' => false
    ],
    'sql' => "text NULL"
];