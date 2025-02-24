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
use Contao\CoreBundle\Controller\ContentElement\HyperlinkController as CoreBundleHyperlinkController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(type: 'hyperlink', category: 'links', priority: 10)]
class HyperlinkController extends CoreBundleHyperlinkController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if ($model->displayAsButton ?? null) {
            $template->set('display_as_button', $model->displayAsButton);

            if ($model->buttonStyle ?? null) {
                $template->set('button_style', $model->buttonStyle);
            }

            if ($model->buttonSize ?? null) {
                $template->set('button_size', $model->buttonSize);
            }

            if ($model->fullWidth ?? null) {
                $template->set('full_width', $model->fullWidth);
            }
        }

        return parent::getResponse($template, $model, $request);
    }
}