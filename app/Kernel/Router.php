<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since 4/7/16
 */
namespace App\Kernel;

/**
 * Class Router.
 */
class Router
{
    /**
     * @param $url
     * @param $controller
     * @param $function
     * @return null
     */
    public function get($url, $controller, $function)
    {
        $filteredUri = strtok($_SERVER["REQUEST_URI"], '?');

        if ($url !== $filteredUri || ! $this->hasGetRequestMethod()) {
            return null;
        }

        return $this->dispatch($controller, $function);
    }

    /**
     * @return bool
     */
    private function hasGetRequestMethod()
    {
        return 'GET' === $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @param $controller
     * @param $function
     * @return mixed
     */
    public function dispatch($controller, $function)
    {
        echo $controller->$function();

        die();
    }

    /**
     * @param $url
     * @param $controller
     * @param $function
     * @return null
     */
    public function post($url, $controller, $function)
    {
        if ($url !== $_SERVER['REQUEST_URI'] || ! $this->hasPostRequestMethod()) {
            return null;
        }

        return $this->dispatch($controller, $function);
    }

    /**
     * @return bool
     */
    private function hasPostRequestMethod()
    {
        return 'POST' === $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @param $url
     * @param $controller
     * @param $function
     * @return null
     */
    public function any($url, $controller, $function)
    {
        if ($url !== $_SERVER['REQUEST_URI']) {
            return null;
        }

        return $this->dispatch($controller, $function);
    }
}
