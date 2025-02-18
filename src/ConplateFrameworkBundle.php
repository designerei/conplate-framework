<?php

namespace designerei\ConplateFrameworkBundle;

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
                ->arrayNode('article')
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
                    ->end()
                ->end()
                ->arrayNode('content')
                    ->addDefaultsIfNotSet()
                    ->children()
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
                    ->end()
                ->end()
                ->arrayNode('disabled_fragments')
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
                ->end()
            ->end()
        ;
    }

    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $container->import('../config/services.yaml');

        $container->parameters()
            ->set('conplate.article.background_color.options', $config['article']['background_color']['options'])
            ->set('conplate.article.background_color.reference', $config['article']['background_color']['reference'])
            ->set('conplate.article.container_size.options', $config['article']['container_size']['options'])
            ->set('conplate.article.container_size.reference', $config['article']['container_size']['reference'])
            ->set('conplate.article.container_spacing.options', $config['article']['container_spacing']['options'])
            ->set('conplate.article.container_spacing.reference', $config['article']['container_spacing']['reference'])
            ->set('conplate.content.headline.options', $config['content']['headline']['options'])
            ->set('conplate.content.headline_style.options', $config['content']['headline_style']['options'])
            ->set('conplate.content.headline_style.reference', $config['content']['headline_style']['reference'])
            ->set('conplate.disabled_fragments.content_elements', $config['disabled_fragments']['content_elements'])
            ->set('conplate.disabled_fragments.frontend_modules', $config['disabled_fragments']['frontend_modules'])
        ;
    }
}