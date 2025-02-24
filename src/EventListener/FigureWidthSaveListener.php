<?php

namespace designerei\ConplateFrameworkBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\StringUtil;

class FigureWidthSaveListener
{
    #[AsCallback(table: 'tl_content', target: 'fields.figureWidth.save')]
    public function __invoke($value)
    {
        $value = StringUtil::deserialize($value);

        if ($value['value']) {
            return $value;

        } else {
            return '';
        }
    }
}