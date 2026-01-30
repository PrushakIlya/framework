<?php

namespace Prushak\Framework\Console\Command;

class CommandAbstract
{
    const GREEN = "\033[32m";
    const RED = "\033[31m";
    const RESET = "\033[0m";

    protected function messageDone($migration_name)
    {
        echo $migration_name . self::GREEN . ' DONE!' . self::RESET . PHP_EOL;
    }
}