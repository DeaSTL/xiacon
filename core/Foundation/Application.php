<?php

namespace Core\Foundation;

use Core\Debug\ExceptionHandler;
use Core\Http\Router;
use Core\Http\View;

class Application
{
    /**
     * Views instance.
     *
     * @var \Core\Http\View
     */
    private $_view;

    /**
     * Router instance.
     *
     * @var \Core\Http\Router
     */
    private $_router;

    /**
     * Ctor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_view = new View();
        $this->_router = new Router();
        new ExceptionHandler();
    }

    /**
     * Runs the application.
     *
     * @return void
     */
    public function run()
    {
        $route = $this->_router->load();
        $view = implode('/', $route['viewpath']);

        if (!$this->_view->viewExists($view)) {
            throw new \RuntimeException("Error, view [$view] does not exist!");
        }

        if (isset($route['get'])) {
            foreach ($route['get'] as $key => $value) {
                $this->_view->with($key, $value);
            }
        }

        echo $this->_view->render($view);
    }
}
