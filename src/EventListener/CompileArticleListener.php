<?php

namespace designerei\ConplateFrameworkBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use Contao\Module;
use Contao\FrontendTemplate;

#[AsHook('compileArticle')]
class CompileArticleListener
{
    public function __invoke(FrontendTemplate $template, array $data, Module $module): void
    {
        $template->element_html_id = $data['cssID'][0];
        $template->element_css_classes = $data['cssID'][1] ?? '';
    }
}