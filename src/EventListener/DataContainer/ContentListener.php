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

        #[Autowire('%conplate.content.button_style.options%')]
        private $buttonStyleOptions,

        #[Autowire('%conplate.content.button_style.reference%')]
        private $buttonStyleReference,

        #[Autowire('%conplate.content.button_style.default%')]
        private $buttonStyleDefault,

        #[Autowire('%conplate.content.button_size.options%')]
        private $buttonSizeOptions,

        #[Autowire('%conplate.content.button_size.reference%')]
        private $buttonSizeReference,

        #[Autowire('%conplate.content.button_size.default%')]
        private $buttonSizeDefault,
    ) {}

    #[AsCallback(table: 'tl_content', target: 'config.onload')]
    public function __invoke(): void
    {
        $GLOBALS['TL_DCA']['tl_content']['fields']['headline']['options'] = $this->headlineOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['sectionHeadline']['options'] = $this->headlineOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['headlineStyle']['options'] = $this->headlineStyleOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['headlineStyle']['reference'] = $this->headlineStyleReference;
        $GLOBALS['TL_DCA']['tl_content']['fields']['sectionHeadlineStyle']['options'] = $this->headlineStyleOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['sectionHeadlineStyle']['reference'] = $this->headlineStyleReference;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonStyle']['options'] = $this->buttonStyleOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonStyle']['reference'] = $this->buttonStyleReference;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonStyle']['default'] = $this->buttonStyleDefault;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonSize']['options'] = $this->buttonSizeOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonSize']['reference'] = $this->buttonSizeReference;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonSize']['default'] = $this->buttonSizeDefault;
    }
}
