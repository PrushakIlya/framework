<?php

namespace Prushak\Framework\Console\Command;

use Prushak\Framework\Container\Psr\ContainerInterface;

class MigrateDatabase extends CommandAbstract implements CommandInterface
{
    public string $name = 'database:migration:migrate';

    public function execute(ContainerInterface $container, array $params = []): int
    {
        if (count($params) === 0) {
            echo 'Please, point a flag' . \PHP_EOL;

            return 0;
        }

        $dbConnect = $container->get('connect_db');
        $pdo = $dbConnect();
        
        $dir = $_SERVER['PWD'] . '/migrations';

        $files = scandir($dir);

        unset($files[0], $files[1]);
        $files = array_reverse($files);
        
        if ($params['flag'] === 'up') {
            $files = array_reverse($files);
        }
        
        for ($i = 0; $i < count($files); $i++) {
            $migration = include_once $_SERVER['PWD'] . '/migrations/' . $files[$i];
            
            $method = $params['flag'];
            $pdo->exec($migration->$method());

            $this->messageDone();
        }

        return 0;
    }
}