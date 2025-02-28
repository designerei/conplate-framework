<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\CoreBundle\String\HtmlAttributes;
use Contao\CoreBundle\Framework\ContaoFramework;
use Contao\CoreBundle\Twig\FragmentTemplate;
use Contao\StringUtil;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: 'miscellaneous', template: 'content_element/layout', nestedFragments: true)]
class LayoutController extends AbstractContentElementController
{
    public function __construct(private readonly ContaoFramework $framework)
    {
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $layoutType = $model->layoutType;
        $layoutClasses = [];

        if ($layoutType === 'flex') {
            $layoutClasses = [
                ['flex'],
                $model->gap,
                $model->alignment,
                $model->flexDirection,
                $model->flexWrap,
            ];
        }

        if ($layoutType === 'grid') {
            $layoutClasses = [
                ['grid'],
                $model->gridTemplateColumns,
                $model->gridTemplateRows,
                $model->gap,
                $model->alignment,
            ];
        }

        if (!empty($layoutClasses)) {
            $classes = [];

            foreach ($layoutClasses as $class) {
                if (!empty($class)) {
                   $classes[] = implode(' ', StringUtil::deserialize($class));
                }
            }
        }

        if (!empty($classes)) {
            $attributes = new HtmlAttributes()
                ->addClass(implode(' ', $classes))
                ->mergeWith($model->attributes)
            ;

            $template->set('attributes', $attributes);
        }

        foreach ($template->get('nested_fragments') as $i => $reference) {
            $nestedModel = $reference->getContentModel();

            if (!$nestedModel instanceof ContentModel) {
                $nestedModel = $this->framework->getAdapter(ContentModel::class)->findById($nestedModel);
            }

            $nestedModel->inLayoutElement = 1;
            $nestedModel->parentLayoutType = $model->layoutType;
            $nestedModel->save();
        }

        return $template->getResponse();
    }
}
