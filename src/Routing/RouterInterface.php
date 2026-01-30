<?php

namespace Prushak\Framework\Routing;

use Prushak\Framework\Http\Request;
use Prushak\Framework\Container\Psr\ContainerInterface;

interface RouterInterface {
    public function dispatch(Request $request, ContainerInterface $container): array;
}