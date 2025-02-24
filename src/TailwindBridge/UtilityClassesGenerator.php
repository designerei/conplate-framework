<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\TailwindBridge;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

class UtilityClassesGenerator
{
    public function __construct(
        #[Autowire('%conplate.tailwind_bridge.core.breakpoints%')]
        private $screens,
    ) {}

    public function generateBasicClasses(string $prefix, array|string $suffixes, array $additional = null): array
    {
        $classes = [];

        // generate classes
        if (is_array($suffixes)) {
            foreach ($suffixes as $suffix) {
                if (empty($suffix) && !is_numeric($suffix)) {
                    $classes[] = $prefix;
                } else {
                    $classes[] = $prefix . '-' . $suffix;
                }
            }
        } else {
            $classes[] = $prefix . '-' . $suffixes;
        }

        // additional classes
        if (!empty($additional)) {
            foreach ($additional as $class) {
                $classes[] = $class;
            }
        }

        return $classes;
    }

    public function generateResponsiveClasses(array $classes): array
    {
        $responsive_classes = [];

        foreach ($classes as $class) {
            $responsive_classes[''][] = $class;
        }

        foreach ($this->screens as $screen) {
            foreach ($classes as $class) {
                $responsive_classes[$screen][] = $screen . ':' . $class;
            }
        }

        return $responsive_classes;
    }

    public function generateClasses(string $prefix = null, array|string $suffixes = null, array $additional = null, bool $responsive = true, bool $arbitrary = false): array
    {
        // arbitrary values
        if ($arbitrary == true) {
            $arbitrary_suffixes = [];
            foreach ($suffixes as $suffix) {
                $arbitrary_suffixes[] = '[' . $suffix . ']';
            }
            $suffixes = $arbitrary_suffixes;
        }

        if ($prefix == null && $suffixes == null && is_array($additional)) {
            $classes = $additional;
        } else {
            $classes = $this->generateBasicClasses($prefix, $suffixes, $additional);
        }

        // responsive classes (extend screen)
        if ($responsive == true) {
            $classes = $this->generateResponsiveClasses($classes);
        }

        return $classes;
    }

    public function mergeClasses(array $classes): array
    {
        $classes = array_merge_recursive(...$classes);
        foreach ($classes as &$item) $item = array_unique($item);

        return $classes;
    }
}