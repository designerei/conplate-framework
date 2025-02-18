<?php

namespace designerei\ConplateFrameworkBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\HeadlineController as CoreBundleHeadlineController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(type: 'headline', category: 'texts', priority: 10)]
class HeadlineController extends CoreBundleHeadlineController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $headline = $template->headline;

        if ($model->headlineStyle ?? null) {
            $headline['style'] = $model->headlineStyle;
        }

        $template->set('headline', $headline);

        return parent::getResponse($template, $model, $request);
    }
}
