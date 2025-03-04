<?php

declare(strict_types=1);

namespace designerei\ConplateFrameworkBundle\TailwindBridge;

use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

class SafelistGenerator
{
    public function __construct(
        #[Autowire('%conplate.tailwind_bridge.config.safelist.dir%')]
        private $dir,

        #[Autowire('%conplate.tailwind_bridge.config.safelist.filename%')]
        private $filename,

        #[Autowire('%kernel.project_dir%')]
        private $rootPath,
    ) {}

    private function getFilePath(): string
    {
        return $this->rootPath . '/' .  $this->dir . '/' . $this->filename . '.txt';
    }

    private function isArrayMulti(array $array): bool
    {
        rsort($array);
        return isset($array[0]) && is_array($array[0]);
    }

    private function createSafelistFile(string $data): void
    {
        // create directory
        if (!file_exists($this->rootPath . '/' . $this->dir)) {
            mkdir($this->rootPath . '/' . $this->dir, 0777, true);
        }

        // create file
        $file = fopen($this->getFilePath(), "w");

        fwrite($file, $data);
        fclose($file);
    }

    private function convertData(array|string $data = ''): string
    {

        if (is_array($data)) {
            if ($this->isArrayMulti($data)) {
                $arrays = $data;
                $imploded = array();
                foreach ($arrays as $array) {
                    $imploded[] = implode(' ', $array);
                }
                $result = implode(' ', $imploded);
            } else {
                $result = implode(' ', $data);
            }
        } else {
            $result = $data;
        }

        return $result;
    }

    public function addToSafelist(array|string $data = ''): void
    {
        if($_ENV['APP_ENV'] == 'dev') {
            if (file_exists($this->getFilePath())) {

                $convertedData = $this->convertData($data);

                // get existing safelist.txt classes and convert to array
                $safelistData = explode(' ', file_get_contents($this->getFilePath()));

                // explode data
                $newData = explode(' ', $convertedData);

                // compare existing and new data; return only if new data exists
                if (array_diff($newData, $safelistData)) {
                    $classes = array_unique(array_merge($newData, $safelistData));
                    $finalData = implode(' ', $classes);

                    // create safelist file
                    $this->createSafelistFile($finalData);
                }
            } else {
                $convertedData = $this->convertData($data);

                // create safelist file
                $this->createSafelistFile($convertedData);
            }
        }
    }
}