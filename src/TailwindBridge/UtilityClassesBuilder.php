<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\TailwindBridge;

use AllowDynamicProperties;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

#[AllowDynamicProperties] class UtilityClassesBuilder
{
    public function __construct(
        #[Autowire('%conplate.tailwind_bridge.core.breakpoints%')]
        private readonly array $breakpoints,

        private readonly SafelistGenerator $safelistGenerator
    ) {}

    public function build(array|string $names, array|string $values, bool $responsive = false , bool $safelist = false): array
    {
        $namesArray = [];
        $valuesArray = [];
        $classesArray = [];

        // set name
        if (\is_string($names)) {
            $names = [$names];
        }

        foreach ($names as $name) {
            $namesArray[] = $name;
        }

        // set value
        if (\is_string($values)) {
            $values = [$values];
        }

        foreach ($values as $value) {
            $valuesArray[] = $value;
        }

        // create classes
        foreach ($namesArray as $name) {
            foreach ($valuesArray as $value) {
                if ($value === '') {
                    $classesArray[] = $name;
                } else {
                    $classesArray[] = $name . '-' . $value;
                }
            }
        }

        // create responsive classes
        if ($responsive) {
            $classes = $classesArray;
            $responsiveClasses = [];

            foreach ($classes as $class) {
                $responsiveClasses[''][] = $class;
            }

            foreach ($this->breakpoints as $breakpoint) {
                foreach ($classes as $class) {
                    $responsiveClasses[$breakpoint][] = $breakpoint . ':' . $class;
                }
            }

            $classesArray = $responsiveClasses;
        }

        // add to safelist
        if ($safelist) {
            $this->safelistGenerator->addToSafelist($classesArray);
        }

        return$classesArray;
    }
}