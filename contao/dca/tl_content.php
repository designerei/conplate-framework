<?php

use Contao\ContentModel;
use Contao\CoreBundle\DataContainer\PaletteManipulator;

$table = ContentModel::getTable();

// palettes
$GLOBALS['TL_DCA'][$table]['palettes']['__selector__'][] = 'displayAsButton';
$GLOBALS['TL_DCA'][$table]['palettes']['__selector__'][] = 'layoutType';

// subpalettes
$GLOBALS['TL_DCA'][$table]['subpalettes']['displayAsButton'] = 'buttonStyle,buttonSize,fullWidth';
$GLOBALS['TL_DCA'][$table]['subpalettes']['layoutType_container'] = 'containerSize,containerCenter';
$GLOBALS['TL_DCA'][$table]['subpalettes']['layoutType_grid'] = 'gridTemplateColumns,gridTemplateRows,gap,alignment';
$GLOBALS['TL_DCA'][$table]['subpalettes']['layoutType_flex'] = 'gap,alignment,flexDirection,flexWrap';

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

$GLOBALS['TL_DCA'][$table]['palettes']['layout'] = '
    {type_legend},type;
    {layout_legend},layoutType;
    {template_legend:hide},customTpl;
    {protected_legend:hide},protected;
    {expert_legend:hide},cssID;
    {invisible_legend:hide},invisible,start,stop'
;

$GLOBALS['TL_DCA'][$table]['palettes']['editor_note'] = '
    {type_legend},title,type;
    {text_legend},editorNote;
    {template_legend:hide},customTpl;
    {protected_legend:hide},protected;
    {expert_legend:hide},cssID;
    {invisible_legend:hide},invisible,start,stop'
;

$palettes = array_keys($GLOBALS['TL_DCA'][$table]['palettes']);

foreach ($palettes as $palette) {
    if ($palette !== '__selector__') {
        PaletteManipulator::create()
            ->addField('headlineStyle', 'headline')
            ->applyToPalette($palette, $table)
        ;

        PaletteManipulator::create()
            ->addLegend('layout_legend', 'expert_legend', PaletteManipulator::POSITION_BEFORE)
            ->addField('spacing', 'layout_legend', PaletteManipulator::POSITION_APPEND)
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

PaletteManipulator::create()
    ->addField(['responsiveImage', 'aspectRatio', 'figureWidth'], 'source_legend', PaletteManipulator::POSITION_APPEND)
    ->applyToPalette('image', 'tl_content')
;

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

$GLOBALS['TL_DCA'][$table]['fields']['buttonStyle'] = [
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'w50'
    ],
    'sql' => "varchar(32) NOT NULL default"
];

$GLOBALS['TL_DCA'][$table]['fields']['buttonSize'] = [
    'inputType' => 'select',
    'eval' => [
        'tl_class' => 'w50',
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

$GLOBALS['TL_DCA'][$table]['fields']['layoutType'] = [
    'exclude' => true,
    'inputType' => 'select',
    'default' => 'container',
    'eval' => [
        'tl_class' => 'w50 clr',
        'mandatory' => false,
        'submitOnChange' => true,
    ],
    'options' => ['container', 'grid', 'flex'],
    'reference' => ['container' => 'Container', 'grid' => 'Grid', 'flex' => 'Flexbox'],
    'sql' => "varchar(16) NOT NULL default 'container'"
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

$GLOBALS['TL_DCA'][$table]['fields']['containerCenter'] = [
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12'
    ],
    'sql' => "char(1) NOT NULL default ''"
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

$commonUtiltityClassField = [
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

$utilityClassFields = [
    'alignment',
    'aspectRatio',
    'spacing',
    'gap',
    'flexDirection',
    'flexWrap',
    'flex',
    'gridTemplateColumns',
    'gridTemplateRows',
    'gridColumn',
    'gridRow',
    'flexBasis',
    'flex',
    'flexGrow',
    'flexShrink',
    'order',
    'alignmentSelf',
];

foreach ($utilityClassFields as $field) {
    $GLOBALS['TL_DCA'][$table]['fields'][$field] = $commonUtiltityClassField;
}

// Individual customizations
$GLOBALS['TL_DCA'][$table]['fields']['spacing']['eval']['tl_class'] .= ' clr';
