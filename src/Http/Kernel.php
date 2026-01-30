<?php

namespace Prushak\Framework\Http;

use Prushak\Framework\Exception\HttpException;
use Prushak\Framework\Container\Psr\ContainerInterface;
use Prushak\Framework\Routing\Router;

class Kernel {
    private string $debug_mode;
    private Router $router;

    public function __construct(
        private ContainerInterface $container
    )
    {
        $this->debug_mode = $this->container->get('debug_mode');
        $this->router = new Router();
    }

     public function handle(Request $request): Response
     {
        try {
            [$routeHandler, $vars] = $this->router->dispatch($request, $this->container);

            $func = new $routeHandler[0]();
            $func->setContainer($this->container);

            $response = call_user_func_array([$func, $routeHandler[1]], [...$vars, $request]);
        }
        catch(\Exception $e) {
           $response = $this->createExceptionResponse($e);
        }

        return $response;
    }

    private function createExceptionResponse(\Exception $exception): Response
    {
        if (in_array($this->debug_mode, ['dev', 'test'])) {
            throw $exception;
        }

        if ($exception instanceof HttpException) {
            return new Response($exception->getMessage(), $exception->getCode());
        }

        return new Response('Server Error', Response::HTTP_SERVER_ERROR);
    }
}