<?php

namespace designerei\ConplateFrameworkBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\CoreBundle\DependencyInjection\Attribute\AsHook;
use designerei\ConplateFrameworkBundle\TailwindBridge\UtilityClassesGenerator;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use designerei\ConplateFrameworkBundle\TailwindBridge\SafelistGenerator;

class DcaFieldsListener
{
    public function __construct(
        private readonly SafelistGenerator $safelistGenerator,

        private readonly UtilityClassesGenerator $utilityClassesGenerator,

        #[Autowire('%conplate.dca_fields.headline.options%')]
        private $headlineOptions,

        #[Autowire('%conplate.tailwind_bridge.layout.aspect_ratio%')]
        private $aspectRatioOptions,

        #[Autowire('%conplate.dca_fields.headline_style.options%')]
        private $headlineStyleOptions,

        #[Autowire('%conplate.dca_fields.headline_style.reference%')]
        private $headlineStyleReference,

        #[Autowire('%conplate.dca_fields.button_style.options%')]
        private $buttonStyleOptions,

        #[Autowire('%conplate.dca_fields.button_style.reference%')]
        private $buttonStyleReference,

        #[Autowire('%conplate.dca_fields.button_style.default%')]
        private $buttonStyleDefault,

        #[Autowire('%conplate.dca_fields.button_size.options%')]
        private $buttonSizeOptions,

        #[Autowire('%conplate.dca_fields.button_size.reference%')]
        private $buttonSizeReference,

        #[Autowire('%conplate.dca_fields.button_size.default%')]
        private $buttonSizeDefault,

        #[Autowire('%conplate.dca_fields.background_color.options%')]
        private $backgroundColorOptions,

        #[Autowire('%conplate.dca_fields.background_color.reference%')]
        private $backgroundColorReference,

        #[Autowire('%conplate.dca_fields.container_size.options%')]
        private $containerSizeOptions,

        #[Autowire('%conplate.dca_fields.container_size.reference%')]
        private $containerSizeReference,

        #[Autowire('%conplate.dca_fields.container_spacing.options%')]
        private $containerSpacingOptions,

        #[Autowire('%conplate.dca_fields.container_spacing.reference%')]
        private $containerSpacingReference,
    ) {}

    #[AsCallback(table: 'tl_content', target: 'config.onload')]
    public function contentListener(): void
    {
        $GLOBALS['TL_DCA']['tl_content']['fields']['aspectRatio']['options'] = $this->utilityClassesGenerator->generateResponsiveClasses($this->aspectRatioOptions);
        $GLOBALS['TL_DCA']['tl_content']['fields']['headline']['options'] = $this->headlineOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['headlineStyle']['options'] = $this->headlineStyleOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['headlineStyle']['reference'] = $this->headlineStyleReference;
        $GLOBALS['TL_DCA']['tl_content']['fields']['sectionHeadline']['options'] = $this->headlineOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['sectionHeadlineStyle']['options'] = $this->headlineStyleOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['sectionHeadlineStyle']['reference'] = $this->headlineStyleReference;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonStyle']['options'] = $this->buttonStyleOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonStyle']['reference'] = $this->buttonStyleReference;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonStyle']['default'] = $this->buttonStyleDefault;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonSize']['options'] = $this->buttonSizeOptions;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonSize']['reference'] = $this->buttonSizeReference;
        $GLOBALS['TL_DCA']['tl_content']['fields']['buttonSize']['default'] = $this->buttonSizeDefault;
    }

    #[AsCallback(table: 'tl_article', target: 'config.onload')]
    public function articleListener(): void
    {
        $GLOBALS['TL_DCA']['tl_article']['fields']['backgroundColor']['options'] = $this->backgroundColorOptions;
        $GLOBALS['TL_DCA']['tl_article']['fields']['backgroundColor']['reference'] = $this->backgroundColorReference;
        $GLOBALS['TL_DCA']['tl_article']['fields']['containerSize']['options'] = $this->containerSizeOptions;
        $GLOBALS['TL_DCA']['tl_article']['fields']['containerSize']['reference'] = $this->containerSizeReference;
        $GLOBALS['TL_DCA']['tl_article']['fields']['containerSpacing']['options'] = $this->containerSpacingOptions;
        $GLOBALS['TL_DCA']['tl_article']['fields']['containerSpacing']['reference'] = $this->containerSpacingReference;
    }

    #[AsHook('initializeSystem')]
    public function addOptionsToSafelist(): void
    {
        $this->safelistGenerator->addToSafelist($this->utilityClassesGenerator->generateResponsiveClasses($this->aspectRatioOptions));
    }
}
