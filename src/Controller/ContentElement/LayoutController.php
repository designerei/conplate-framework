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
    public function __construct(
        private readonly ContaoFramework $framework)
    {
    }

    protected function getResponse(FragmentTemplate $template, ContentModel $model, Request $request): Response
    {
        $layoutClasses = $this->getLayoutClasses($model);

        if (!empty($layoutClasses)) {
            $attributes = new HtmlAttributes()
                ->addClass($this->generateClasses($layoutClasses))
                ->mergeWith($model->attributes)
            ;
            $template->set('attributes', $attributes);
        }

        $nestedFragments = [];

        foreach ($template->get('nested_fragments') as $i => $reference) {
            $nestedModel = $reference->getContentModel();

            if (!$nestedModel instanceof ContentModel) {
                $nestedModel = $this->framework->getAdapter(ContentModel::class)->findById($nestedModel);
            }

            $nestedClasses = $this->getNestedLayoutClasses($nestedModel, $model->layoutType);

            if (!empty($nestedClasses)) {
                $reference->attributes['classes'] = [$this->generateClasses($nestedClasses)];
            }

            $reference->attributes['templateProperties'] = [
                'nested_in_layout' => 1,
                'parent_layout_type' => $model->layoutType
            ];

            $nestedFragments[$i] = $reference;
        }

        $template->set('nested_fragments', $nestedFragments);

        return $template->getResponse();
    }

    private function getLayoutClasses(ContentModel $model): array
    {
        return match ($model->layoutType) {
            'flex' => [
                ['flex'],
                $model->gap,
                $model->alignment,
                $model->flexDirection,
                $model->flexWrap,
            ],
            'grid' => [
                ['grid'],
                $model->gridTemplateColumns,
                $model->gridTemplateRows,
                $model->gap,
                $model->alignment,
            ],
            'container' => [
                $model->containerSize,
                $model->containerCenter ? 'mx-auto' : '',
            ],
            default => [],
        };
    }

    private function getNestedLayoutClasses(ContentModel $nestedModel, string $parentLayoutType): array
    {
        return match ($parentLayoutType) {
            'flex' => [
                $nestedModel->flexBasis,
                $nestedModel->flex,
                $nestedModel->flexGrow,
                $nestedModel->flexShrink,
                $nestedModel->order,
                $nestedModel->alignmentSelf,
            ],
            'grid' => [
                $nestedModel->gridColumn,
                $nestedModel->gridRow,
                $nestedModel->order,
                $nestedModel->alignmentSelf,
            ],
            default => [],
        };
    }

    private function generateClasses(array $classes): string
    {
        $strClasses = '';

        foreach ($classes as $class) {
            if(!empty($class)) {
                $class = StringUtil::deserialize($class);
                if (is_array($class)) {
                    $strClasses .= ' ' . implode(' ', $class);
                } else {
                    $strClasses .= ' ' . $class;
                }
            }
        }

        return ltrim($strClasses);
    }
}
