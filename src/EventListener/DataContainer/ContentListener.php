<?php

namespace designerei\ConplateFrameworkBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ContentListener
{
    public function __construct(
        #[Autowire('%conplate.content.headline.options%')]
        private $headlineOptions,

        #[Autowire('%conplate.content.headline_style.options%')]
        private $headlineStyleOptions,

        #[Autowire('%conplate.content.headline_style.reference%')]
        private $headlineStyleReference,
    ) {}

    #[AsCallback(table: 'tl_content', target: 'config.onload')]
    public function __invoke(): void
    {
        $GLOBALS['TL_DCA']['tl_content']['fields']['headline']['options'] = $this->headlineOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['headlineStyle']['options'] = $this->headlineStyleOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['headlineStyle']['reference'] = $this->headlineStyleReference;
    }
}