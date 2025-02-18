<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\PageModel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'miscellaneous')]
class CopylineController extends AbstractContentElementController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $currentPage = $this->getPageModel();
        $rootPage = PageModel::findOneBy('id', $currentPage->rootId);

        // set text
        $text = $rootPage->title;

        // check if copyline is defined
        if ($rootPage->copyline) {
            $text = $rootPage->copyline;
        }

        $template->set('text', $text);

        return $template->getResponse();
    }
}
