<?php

namespace Core\Http;

use Philo\Blade\Blade;

/**
 * View master class.
 */
class View
{
    /**
     * The view to be loaded.
     *
     * @var \Illuminate\View\View
     */
    private $_view;

    /**
     * The data to pass on to the view.
     *
     * @var array
     */
    private $_data = [];

    /**
     * The Blade Templating object.
     *
     * @var \Philo\Blade\Blade
     */
    private $_blade;

    /**
     * The Blade parsing Factory class.
     *
     * @var \Illuminate\View\Factory
     */
    private $_factory;

    /**
     * Class Constructor // Creates new Blade and View instances
     * Creates View instance from parsed Blade instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->createBlade(views_path(), views_path().'/../cache');
    }

    /**
     * Creates a new Blade instance.
     *
     * @param string $views - The views path
     * @param string $cache - The cache path
     *
     * @return void
     */
    public function createBlade($views, $cache)
    {
        $this->_blade = new Blade($views, $cache);
        $this->_view = $this->_blade->view();
    }

    /**
     * Renders the view.
     *
     * @param string $path - The path of the view
     *
     * @return mixed
     */
    public function render($path)
    {
        $this->parseContent($path, $this->_data);
        echo $this->_factory->render();
    }

    /**
     * Adds data to pass onto the view.
     *
     * @param string $key   - The key of the data to pass through
     * @param string $value - The $key's value
     *
     * @return \Scara\Http\View
     */
    public function with($key, $value = null)
    {
        if (is_array($key)) {
            $this->_data = array_merge($this->_data, $key);
        } else {
            $this->_data[$key] = $value;
        }

        return $this;
    }

    /**
     * Checks whether or not data is being passed to
     * the view.
     *
     * @return bool
     */
    public function hasData()
    {
        if (empty($this->_data)) {
            return false;
        } else {
            return true;
        }
    }

    /**
     * Static function to check if a view exists.
     *
     * @param string $path
     *
     * @return bool
     */
    public static function exists($path)
    {
        $view = new self();

        return $view->viewExists($path);
    }

    /**
     * Static function to render a view.
     *
     * @param string $path
     * @param string $data
     * @param string $data
     *
     * @return mixed
     */
    public static function renderView($path, $dataName = '', $data = '')
    {
        $view = new self();
        if (!empty($dataName)) {
            $view->with($dataName, $data);
        }

        return $view->render($path, false);
    }

    /**
     * Checks if a view exists.
     *
     * @param string $path
     *
     * @return bool
     */
    public function viewExists($path)
    {
        return $this->_view->exists($path);
    }

    /**
     * Parses the view using the Blade Factory.
     *
     * @param string $path - The path of the view to parse
     * @param string $data - Data to pass on to the view
     *
     * @return void
     */
    private function parseContent($path, $data)
    {
        $path = str_replace('.', '/', $path);
        $this->_factory = $this->_view->make($path, $data);
    }
}
