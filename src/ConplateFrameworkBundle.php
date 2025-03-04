<?php

namespace designerei\ConplateFrameworkBundle;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class ConplateFrameworkBundle extends AbstractBundle
{
    protected string $extensionAlias = 'conplate';

    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->rootNode()
            ->children()
                ->append($this->disabledFragmentsNode())
                ->arrayNode('dca_fields')
                    ->arrayPrototype()
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->arrayNode('options')
                                ->variablePrototype()->end()
                                ->defaultValue([])
                                ->children()
                                    ->arrayNode('utilites')
                                        ->scalarPrototype()->end()
                                        ->defaultValue([])
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode('reference')
                                ->normalizeKeys(false)
                                ->scalarPrototype()->end()
                                ->defaultValue([])
                            ->end()
                            ->scalarNode('default')
                                ->defaultValue(null)
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->append($this->tailwindBridgeNode())
            ->end()
        ;
    }

    public function disabledFragmentsNode(): NodeDefinition
    {
        $treebuilder = new Treebuilder('disabled_fragments');

        return $treebuilder->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('content_elements')
                    ->useAttributeAsKey('name')
                    ->normalizeKeys(false)
                    ->arrayPrototype()
                        ->scalarPrototype()->end()
                    ->end()
                ->end()
                ->arrayNode('frontend_modules')
                    ->useAttributeAsKey('name')
                    ->normalizeKeys(false)
                    ->arrayPrototype()
                        ->scalarPrototype()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    public function tailwindBridgeNode(): NodeDefinition
    {
        $treebuilder = new Treebuilder('tailwind_bridge');

        return $treebuilder->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('config')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('safelist')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('dir')
                                    ->defaultValue('var/tailwind/safelist')
                                ->end()
                                ->scalarNode('filename')
                                    ->defaultValue('safelist')
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('core')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('breakpoints')
                            ->scalarPrototype()->end()
                            ->defaultValue([])
                        ->end()
                        ->arrayNode('spacing')
                            ->scalarPrototype()->end()
                            ->defaultValue([])
                        ->end()
                    ->end()
                ->end()
                ->append($this->tailwindBridgeUtilitiesNode())
            ->end()
        ;
    }


    public function tailwindBridgeUtilitiesNode(): NodeDefinition
    {
        $treebuilder = new Treebuilder('utilities');

        return $treebuilder->getRootNode()
            ->arrayPrototype()
                ->addDefaultsIfNotSet()
                ->children()
                     ->arrayNode('name')
                        ->scalarPrototype()->end()
                        ->defaultValue([])
                    ->end()
                    ->arrayNode('value')
                        ->scalarPrototype()->end()
                        ->defaultValue([])
                    ->end()
                    ->booleanNode('responsive')
                        ->defaultNull()
                    ->end()
                ->end()
            ->end()
        ;
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {

        $container->import('../config/services.yaml');

        $container->parameters()
            ->set('conplate.tailwind_bridge.core.breakpoints', $config['tailwind_bridge']['core']['breakpoints'])
            ->set('conplate.tailwind_bridge.core.spacing', $config['tailwind_bridge']['core']['spacing'])
            ->set('conplate.tailwind_bridge.config.safelist.dir', $config['tailwind_bridge']['config']['safelist']['dir'])
            ->set('conplate.tailwind_bridge.config.safelist.filename', $config['tailwind_bridge']['config']['safelist']['filename'])
            ->set('conplate.tailwind_bridge.utilities', $config['tailwind_bridge']['utilities'])
            ->set('conplate.dca_fields', $config['dca_fields'])
            ->set('conplate.disabled_fragments.content_elements', $config['disabled_fragments']['content_elements'])
            ->set('conplate.disabled_fragments.frontend_modules', $config['disabled_fragments']['frontend_modules'])
        ;
    }
}
