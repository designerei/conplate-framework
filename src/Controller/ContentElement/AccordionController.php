<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AccordionController as CoreBundleAccordionController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(type: 'accordion', category: 'miscellaneous', nestedFragments: true, priority: 10)]
class AccordionController extends CoreBundleAccordionController
{
    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $template->set('multi_selectable', $model->multiSelectable ?? '');
        $template->set('close_sections', !$model->closeSections ?? '');

        $elements = [];

        foreach ($template->get('nested_fragments') as $i => $reference) {
            $nestedModel = $reference->getContentModel();

            if (!$nestedModel instanceof ContentModel) {
                $nestedModel = parent::getContaoAdapter(ContentModel::class)->findById($nestedModel);
            }

            $header = StringUtil::deserialize($nestedModel->sectionHeadline, true);

            $elements[] = [
                'header' => $header['value'] ?? '',
                'header_tag' => $header['unit'] ?? 'h2',
                'header_style' => $nestedModel->sectionHeadlineStyle ?? '',
                'reference' => $reference,
                'is_open' => !$model->closeSections && 0 === $i
            ];
        }

        $template->set('elements', $elements);

        return $template->getResponse();
    }
}