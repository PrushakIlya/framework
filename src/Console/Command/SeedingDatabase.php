<?php

namespace Prushak\Framework\Console\Command;

use Prushak\Framework\Container\Psr\ContainerInterface;

class SeedingDatabase extends CommandAbstract implements CommandInterface
{
    public string $name = 'database:seed';

    public function execute(ContainerInterface $container, array $params = []): int
    {
        if (count($params) === 0) {
            echo 'Please, point a flag' . \PHP_EOL;

            return 0;
        }

        $dbConnect = $container->get('connect_db');
        $pdo = $dbConnect();
        
        $seed = include_once $_SERVER['PWD'] . '/database/seeds/' . $params['class'] . '.php';
        
        $seed->run($pdo);

        $this->messageDone($params['class']);

        return 0;
    }
}