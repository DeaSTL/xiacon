<?php

namespace Core\Http;

class Router
{
    /**
     * Executes the router and loads the current route.
     *
     * @return array
     */
    public function load()
    {
        $uriexp = array_values(array_filter(explode('/', $_SERVER['REQUEST_URI'])));
        $bp = env('BASEPATH', '/');
        $basepath = ($bp == '/') ? $bp : str_replace('/', '', $bp);

        $route = ['basepath' => $basepath];

        if (count($uriexp) > 1) {
            foreach ($uriexp as $item) {
                if ($item !== $basepath) {
                    $getexp = explode('?', $item);
                    $get = [];

                    if (count($getexp) == 1) {
                        $route['viewpath'][] = $item;
                    } else {
                        $route['viewpath'][] = $getexp[0];

                        foreach (explode('&', $getexp[1]) as $q) {
                            $i = explode('=', $q);
                            $get[$i[0]] = urldecode($i[1]);
                        }
                    }

                    if (!empty($get)) {
                        $route['get'] = $get;
                    }
                }
            }
        } else {
            $route = ['viewpath' => ['default', 'index']];
        }

        // Make sure an index view can be loaded in
        // sub directory
        if (count($route['viewpath']) == 1) {
            $route['viewpath'][] = 'index';
        }

        return $route;
    }
}
