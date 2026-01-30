<?php

namespace Prushak\Framework\Controller;

use Prushak\Framework\Http\Response;
use Prushak\Framework\Container\Psr\ContainerInterface;

class AbstractController {
    protected ?ContainerInterface $container = null;

    public function setContainer(ContainerInterface $container)
    {
       $this->container = $container;
    }

    protected  function render(string $template, array $parameters = []): Response
    {
        $smarty = $this->container->get('smarty');

        $smarty->setTemplateDir($this->container->get('template_path'));
        $smarty->setCompileDir($this->container->get('compile_dir'));
        $smarty->setCacheDir($this->container->get('cache_dir'));

        foreach ($parameters as $key => $value) {
            $smarty->assign($key, $value);
        }

        $smarty->display($template);

        return new Response($template);
    }
}