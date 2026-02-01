<?php

namespace Prushak\Framework\Routing;

use Prushak\Framework\Exception\HttpException;
use Prushak\Framework\Exception\HttpRequestMethodException;
use Prushak\Framework\Http\Request;
use Prushak\Framework\Container\Psr\ContainerInterface;

class Router implements RouterInterface {
    public function dispatch(Request $request, ContainerInterface $container): array
    {
        $route = explode('/', $request->getPathInfo());

        foreach ($container->get('routes') as $item) {
            $pattern = explode('/', $item[1]);

            $controller = $item[2][0];
            $method = $item[2][1];

            if (count($route) === 2) {
                return [$controller, $method, []];
            }

            $count = 0;
            $arg = null;

            foreach ($route as $id=>$el) {
                if (!empty($pattern[$id])) {
                    if ($pattern[$id] === '[0-9]') {
                        $arg = $el;
                    }

                    if (preg_match('/^' . $pattern[$id] . '+$/', $el, $matches)) {
                        $count++;
                    }
                }
            }

            if ($count === count($route) - 1 ?? 1 && count($route) === count($pattern)) {
                return [$controller, $method, [$arg]];
            }
        }

        return [null, null];
    }
}