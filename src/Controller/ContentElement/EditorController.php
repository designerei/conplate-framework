<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\String\HtmlAttributes;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(type: 'editor_note', category: 'editor')]
#[AsContentElement(type: 'editor_placeholder', category: 'editor', nestedFragments: true)]
class EditorController extends AbstractContentElementController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if ('editor_note' === $this->getType()) {
            if ($model->editorNote)
            {
                $editorNote = nl2br($model->editorNote, false);
            }

            $template->set('note', $editorNote ?: '');
        }

        if ('editor_placeholder' === $this->getType()) {
            $innerAttributes = (new HtmlAttributes());

            if ($model->aspectRatio) {
                $innerAttributes
                    ->addClass(StringUtil::deserialize($model->aspectRatio))
                ;
            }

            $template->set('inner_attributes', $innerAttributes);
        }

        return $template->getResponse();
    }
}