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
                ->append($this->dcaFieldsNode())
                ->append($this->tailwindBridgeNode())
            ->end()
        ;
    }

    public function dcaFieldsNode(): NodeDefinition
    {
        $treebuilder = new Treebuilder('dca_fields');

        return $treebuilder->getRootNode()
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('background_color')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('options')
                            ->scalarPrototype()->end()
                        ->end()
                        ->arrayNode('reference')
                            ->normalizeKeys(false)
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('container_size')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('options')
                            ->scalarPrototype()->end()
                        ->end()
                        ->arrayNode('reference')
                            ->normalizeKeys(false)
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('container_spacing')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('options')
                            ->scalarPrototype()->end()
                        ->end()
                        ->arrayNode('reference')
                            ->normalizeKeys(false)
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('aspect_ratio')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('options')
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('headline')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('options')
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('headline_style')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('options')
                            ->scalarPrototype()->end()
                        ->end()
                        ->arrayNode('reference')
                            ->normalizeKeys(false)
                            ->scalarPrototype()->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('button_style')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('options')
                            ->scalarPrototype()->end()
                        ->end()
                        ->arrayNode('reference')
                            ->normalizeKeys(false)
                            ->scalarPrototype()->end()
                        ->end()
                        ->scalarNode('default')->defaultNull()->end()
                    ->end()
                ->end()
                ->arrayNode('button_size')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('options')
                            ->scalarPrototype()->end()
                        ->end()
                        ->arrayNode('reference')
                            ->normalizeKeys(false)
                            ->scalarPrototype()->end()
                        ->end()
                        ->scalarNode('default')->defaultNull()->end()
                    ->end()
                ->end()
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
                ->arrayNode('core')
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
                        ->arrayNode('breakpoints')
                            ->scalarPrototype()->end()
                            ->defaultValue([])
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('layout')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('aspect_ratio')
                            ->scalarPrototype()->end()
                            ->defaultValue([])
                        ->end()
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
            ->set('conplate.tailwind_bridge.core.safelist.dir', $config['tailwind_bridge']['core']['safelist']['dir'])
            ->set('conplate.tailwind_bridge.core.safelist.filename', $config['tailwind_bridge']['core']['safelist']['filename'])
            ->set('conplate.tailwind_bridge.layout.aspect_ratio', $config['tailwind_bridge']['layout']['aspect_ratio'])
            ->set('conplate.dca_fields.background_color.options', $config['dca_fields']['background_color']['options'])
            ->set('conplate.dca_fields.background_color.reference', $config['dca_fields']['background_color']['reference'])
            ->set('conplate.dca_fields.container_size.options', $config['dca_fields']['container_size']['options'])
            ->set('conplate.dca_fields.container_size.reference', $config['dca_fields']['container_size']['reference'])
            ->set('conplate.dca_fields.container_spacing.options', $config['dca_fields']['container_spacing']['options'])
            ->set('conplate.dca_fields.container_spacing.reference', $config['dca_fields']['container_spacing']['reference'])
            ->set('conplate.dca_fields.aspect_ratio.options', $config['dca_fields']['aspect_ratio']['options'])
            ->set('conplate.dca_fields.headline.options', $config['dca_fields']['headline']['options'])
            ->set('conplate.dca_fields.headline_style.options', $config['dca_fields']['headline_style']['options'])
            ->set('conplate.dca_fields.headline_style.reference', $config['dca_fields']['headline_style']['reference'])
            ->set('conplate.dca_fields.button_style.options', $config['dca_fields']['button_style']['options'])
            ->set('conplate.dca_fields.button_style.reference', $config['dca_fields']['button_style']['reference'])
            ->set('conplate.dca_fields.button_style.default', $config['dca_fields']['button_style']['default'])
            ->set('conplate.dca_fields.button_size.options', $config['dca_fields']['button_size']['options'])
            ->set('conplate.dca_fields.button_size.reference', $config['dca_fields']['button_size']['reference'])
            ->set('conplate.dca_fields.button_size.default', $config['dca_fields']['button_size']['default'])
            ->set('conplate.disabled_fragments.content_elements', $config['disabled_fragments']['content_elements'])
            ->set('conplate.disabled_fragments.frontend_modules', $config['disabled_fragments']['frontend_modules'])
        ;
    }
}
