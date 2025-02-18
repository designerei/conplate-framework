<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\EventListener;

use Contao\CoreBundle\DependencyInjection\Attribute\AsCallback;
use Contao\DataContainer;
use Contao\System;
use Contao\CoreBundle\Security\ContaoCorePermissions;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class DisableBackendFragmentsListener
{
    public function __construct(
        #[Autowire('%conplate.disabled_fragments.content_elements%')]
        private $contentElements,

        #[Autowire('%conplate.disabled_fragments.frontend_modules%')]
        private $frontendModules,
    ) {}

    public function disableBackendFragments(array $disabledFragments, array $existingFragments): array
    {
        $security = System::getContainer()->get('security.helper');
        $groups = [];
        $fragments = [];

        foreach ($disabledFragments as $fragment) {
            foreach ($fragment as $f) {
                $fragments[] = $f;
            }
        }

        foreach ($existingFragments as $k=>$v)
        {
            foreach (array_keys($v) as $kk)
            {
                if (
                    $security->isGranted(ContaoCorePermissions::USER_CAN_ACCESS_FRONTEND_MODULE_TYPE, $kk) &&
                    !in_array($kk, $fragments)
                )
                {
                    $groups[$k][] = $kk;
                }
            }
        }

        return $groups;
    }

    #[AsCallback(table: 'tl_content', target: 'fields.type.options', priority: 10)]
    public function disableContentElements(DataContainer $dc): array
    {
        return $this->disableBackendFragments($this->contentElements, $GLOBALS['TL_CTE']);
    }

    #[AsCallback(table: 'tl_module', target: 'fields.type.options', priority: 10)]
    public function disableFrontendModules(DataContainer $dc): array
    {
        return $this->disableBackendFragments($this->frontendModules, $GLOBALS['FE_MOD']);
    }
}
