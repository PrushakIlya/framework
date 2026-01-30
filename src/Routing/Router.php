<?php

namespace Prushak\Framework\Routing;

use Prushak\Framework\Exception\HttpException;
use Prushak\Framework\Exception\HttpRequestMethodException;
use Prushak\Framework\Http\Request;
use Prushak\Framework\Container\Psr\ContainerInterface;

class Router implements RouterInterface {
    public function dispatch($request, $container): array
    {
        foreach ($container->get('routes') as $item) {
            $pattern = explode('/', $item[1]);
            $route = explode('/', $request->getPathInfo());

            if (!empty($pattern[2]) and !empty($route[2])) {
                if ($route[1] === $pattern[1]) {
                    preg_match('/' . $pattern[2] . '+/', $route[2], $matches);

                    return ([[$item[2][0], $item[2][1]], [$matches[0]]]);
                }
            }

            if ($request->getPathInfo() === $item[1]) {
                return [[$item[2][0], $item[2][1]], []];
            }
        }

        return [];
    }
}