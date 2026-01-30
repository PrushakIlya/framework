<?php

namespace Prushak\Framework\Console;

use Prushak\Framework\Console\Command\CommandInterface;
use Prushak\Framework\Container\Psr\ContainerInterface;

class Kernel {
    public function __construct(
        private ContainerInterface $container,
        private Application $application,
    ){
    }

    public function handle(): int
    {
        $this->registerCommands();

        return $this->application->run();
    }

    private function registerCommands(): void
    {
        $commandFiles = new \DirectoryIterator(__DIR__ . '/Command');
   
        $baseNamespace = $this->container->get('base-commands-namespace');

        foreach ($commandFiles as $file) {
            if (!$file->isFile()) {
                continue;
            }

            $fileNamespace = $baseNamespace . pathinfo($file, PATHINFO_FILENAME);

            if (is_subclass_of($fileNamespace, CommandInterface::class)) {
                $aliasName = (new \ReflectionClass($fileNamespace))->getProperty('name')->getDefaultValue();
                
                $this->container->add($aliasName, $fileNamespace);
            }
        }
    }
}