<?php

namespace designerei\ConplateFrameworkBundle\EventListener\DataContainer;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use designerei\ConplateFrameworkBundle\TailwindBridge\UtilityClassesBuilder;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class DcaFieldsListener
{
    public function __construct(
        private readonly UtilityClassesBuilder $utilityClassesBuilder,

        #[Autowire('%conplate.dca_fields%')]
        private $dcaFields,

        #[Autowire('%conplate.tailwind_bridge.utilities%')]
        private $tailwindBridgeUtilities,
    ) {}

    #[AsCallback(table: 'tl_content', target: 'config.onload')]
    public function contentConfigCallbackListener(): void
    {
        $table = 'tl_content';
        $this->updateDcaFieldsWithConfigValues($table, $this->dcaFields);
    }

    #[AsCallback(table: 'tl_article', target: 'config.onload')]
    public function articleConfigCallbackListener(): void
    {
        $table = 'tl_article';
        $this->updateDcaFieldsWithConfigValues($table, $this->dcaFields);
    }

    private function updateDcaFieldsWithConfigValues(string $table, array $fields): void
    {
        $dcaFields = &$GLOBALS['TL_DCA'][$table]['fields'];

        foreach ($fields as $field => $settings) {
            $field = $this->snakeToCamelCase($field);

            if (array_key_exists($field, $dcaFields)) {
                foreach ($settings as $key => $value) {
                    if ($key == 'options' && isset($value['utilities'])) {
                        $options = $this->processUtilities($value['utilities']);
                        $dcaFields[$field]['options'] = $options;
                    } else {
                        $dcaFields[$field][$key] = $value;
                    }
                }
            }
        }
    }

    private function processUtilities(array $utilities): array
    {
        $tailwindUtilities = $this->tailwindBridgeUtilities;
        $collection = [];

        foreach ($utilities as $utility) {
            foreach ($tailwindUtilities as $tailwindUtility => $values) {
                if ($tailwindUtility == $utility) {
                    $collection[] = $this->utilityClassesBuilder->build(
                        $values['name'],
                        $values['value'],
                        $values['responsive'] ?? true,
                        $values['safelist'] ?? true);
                }
            }
        }

        return array_merge_recursive(...$collection);
    }

    private function snakeToCamelCase(string $input): string
    {
        return \lcfirst(\str_replace('_', '', \ucwords($input, '_')));
    }
}
