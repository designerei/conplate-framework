<?php

declare(strict_types=1);

/*
 * This file is part of Contao.
 *
 * (c) Leo Feyer
 *
 * @license LGPL-3.0-or-later
 */

namespace designerei\ConplateFrameworkBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\ImagesController as CoreBundleImagesController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\StringUtil;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement('image', category: 'media', priority: 10)]
#[AsContentElement('gallery', category: 'media', priority: 10)]
class ImagesController extends CoreBundleImagesController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if ($model->responsiveImage ?? null) {
            $template->set('responsive_image', $model->responsiveImage ?? false);
        }

        if ($model->figureWidth ?? null) {
            $template->set('figure_width', $model->figureWidth ?? false);
        }

        if ($model->aspectRatio ?? null) {
            $aspectRatio = implode(' ', StringUtil::deserialize($model->aspectRatio));
            $template->set('aspect_ratio', $aspectRatio);
        }

        if ($model->borderRadius ?? null) {
            $borderRadius = implode(' ', StringUtil::deserialize($model->borderRadius));
            $template->set('border_radius', $borderRadius);
        }

        return parent::getResponse($template, $model, $request);
    }
}