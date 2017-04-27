<?php

use Core\Environment;
use Core\Singleton;
use Core\UrlGenerator;

if (!function_exists('asset')) {
    /**
     * Generates a URL for an asset.
     *
     * @param string $path
     *
     * @return string
     */
    function asset($path)
    {
        return Singleton::call(UrlGenerator::class, 'asset', [$path]);
    }
}

if (!function_exists('script')) {
    /**
     * Generates an HTML script tag with the given script path.
     *
     * @param string $path
     *
     * @return string
     */
    function script($path)
    {
        return '<script src="'.asset('js/'.$path).'"> type="text/javascript"></script>';
    }
}

if (!function_exists('style')) {
    /**
     * Generates an HTML link tag with the given script path.
     *
     * @param string $path
     *
     * @return string
     */
    function style($path)
    {
        return '<link rel="stylesheet" type="text/css" href="'.asset('css/'.$path).'">';
    }
}

if (!function_exists('link_to')) {
    /**
     * Generates an anchor tag to the given URL.
     *
     * @param string $url
     *
     * @return string
     */
    function link_to($url)
    {
        return Singleton::call(UrlGenerator::class, 'to', [$url]);
    }
}

if (!function_exists('env')) {
    /**
     * Gets an environment variable.
     *
     * @param string $key
     * @param string $default
     *
     * @return string
     */
    function env($key, $default = '')
    {
        return Singleton::call(Environment::class, 'get', [$key, $default]);
    }
}

if (!function_exists('env_set')) {
    /**
     * Sets an environment variable.
     *
     * @param string $key
     * @param string $value
     *
     * @return string
     */
    function env_set($key, $value)
    {
        return Singleton::call(Environment::class, 'set', [$key, $value]);
    }
}

if (!function_exists('base_path')) {
    /**
     * Gets the base app path.
     *
     * @return string
     */
    function base_path()
    {
        return getcwd();
    }
}
