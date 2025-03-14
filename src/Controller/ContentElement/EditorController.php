<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(type: 'editor_note', category: 'texts')]
class EditorController extends AbstractContentElementController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        if ($model->editorNote)
        {
            $editorNote = nl2br($model->editorNote, false);
        }

        $template->set('note', $editorNote ?: '');

        return $template->getResponse();
    }
}