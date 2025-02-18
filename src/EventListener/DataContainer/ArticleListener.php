<?php

namespace designerei\ConplateFrameworkBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class ArticleListener
{
    public function __construct(
        #[Autowire('%conplate.article.background_color.options%')]
        private $backgroundColorOptions,

        #[Autowire('%conplate.article.background_color.reference%')]
        private $backgroundColorReference,

        #[Autowire('%conplate.article.container_size.options%')]
        private $containerSizeOptions,

        #[Autowire('%conplate.article.container_size.reference%')]
        private $containerSizeReference,

        #[Autowire('%conplate.article.container_spacing.options%')]
        private $containerSpacingOptions,

        #[Autowire('%conplate.article.container_spacing.reference%')]
        private $containerSpacingReference,
    ) {}

    #[AsCallback(table: 'tl_article', target: 'config.onload')]
    public function __invoke(): void
    {
        $GLOBALS['TL_DCA']['tl_article']['fields']['backgroundColor']['options'] = $this->backgroundColorOptions;
        $GLOBALS['TL_DCA']['tl_article']['fields']['backgroundColor']['reference'] = $this->backgroundColorReference;
        $GLOBALS['TL_DCA']['tl_article']['fields']['containerSize']['options'] = $this->containerSizeOptions;
        $GLOBALS['TL_DCA']['tl_article']['fields']['containerSize']['reference'] = $this->containerSizeReference;
        $GLOBALS['TL_DCA']['tl_article']['fields']['containerSpacing']['options'] = $this->containerSpacingOptions;
        $GLOBALS['TL_DCA']['tl_article']['fields']['containerSpacing']['reference'] = $this->containerSpacingReference;
    }
}