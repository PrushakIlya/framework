<?php

namespace Prushak\Framework\Console\Command;

use Prushak\Framework\Container\Psr\ContainerInterface;

interface CommandInterface {
    public function execute(ContainerInterface $container, array $params): int;
}