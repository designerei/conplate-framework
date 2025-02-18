<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Routing\ContentUrlGenerator;
use Contao\CoreBundle\String\HtmlAttributes;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'miscellaneous')]
class LogoController extends AbstractContentElementController
{
    public function __construct(private readonly ContentUrlGenerator $contentUrlGenerator)
    {
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $currentPage = $this->getPageModel();
        $targetPage = PageModel::findFirstPublishedByPid($currentPage->rootId);

        if ($targetPage) {

            $linkAttributes = (new HtmlAttributes())
                ->set('href', $this->contentUrlGenerator->generate($targetPage, [], UrlGeneratorInterface::ABSOLUTE_PATH))
                ->set('title', $targetPage->title)
            ;

            $text = $targetPage->title;

            $template->set('text', $text);
            $template->set('link_attributes', $linkAttributes);
        }

        return $template->getResponse();
    }
}
