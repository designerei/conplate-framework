<?php

namespace designerei\ConplateFrameworkBundle\EventListener;

use Contao\ContentModel;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Contao\StringUtil;

#[AsEventListener]
class ContentElementReferenceListener
{
    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if (!$request->attributes->has('contentModel')) {
            return;
        }

        $contentModel = $request->attributes->get('contentModel');

        if (!$contentModel instanceof ContentModel) {
            $contentModel = ContentModel::findByPk($contentModel);
        }

        // spacing
        if ($contentModel->spacing) {
            // set hasSpacing properties
            $templateProperties = $request->attributes->get('templateProperties');
            $templateProperties['has_spacing'] = 1;
            $request->attributes->set('templateProperties', $templateProperties);

            // get spacing
            $spacing = Implode(' ', StringUtil::deserialize($contentModel->spacing));

            // set spacing
            $classes = $request->attributes->get('classes');
            $classes = [$spacing];
            $request->attributes->set('classes', $classes);
        }
    }
}