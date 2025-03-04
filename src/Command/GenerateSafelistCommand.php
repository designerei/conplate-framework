<?php

namespace designerei\ConplateFrameworkBundle\Command;

use designerei\ConplateFrameworkBundle\TailwindBridge\UtilityClassesBuilder;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'conplate:generate-safelist',
    description: 'Generate safelist file based on utilities configuration'
)]
class GenerateSafelistCommand extends Command
{
    public function __construct(
        private readonly UtilityClassesBuilder $utilityClassesBuilder,

        #[Autowire('%conplate.tailwind_bridge.utilities%')]
        private $tailwindBridgeUtilities,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->generateSafelist();

        $io = new SymfonyStyle($input, $output);
        $io->success('Safelist generated.');

        return Command::SUCCESS;
    }

    private function generateSafelist(): void
    {
        $collection = [];

        foreach ($this->tailwindBridgeUtilities as $tailwindUtility => $values) {
                $collection[$tailwindUtility] = $this->utilityClassesBuilder->build(
                    $values['name'],
                    $values['value'],
                    $values['responsive'] ?? true,
                    true
                );
        }
    }
}