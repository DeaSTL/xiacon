<?php

namespace Core\Utils;

class Singleton
{
    /**
     * Statically call a class/method that's not static.
     *
     * @param mixed  $classname
     * @param string $method
     * @param array  $params
     *
     * @return mixed
     */
    public static function call($classname, $method, $params = [])
    {
        $class = new $classname();

        switch (count($params)) {
            case 0:
            return $class->$method();
            case 1:
            return $class->$method($params[0]);
            case 2:
            return $class->$method($params[0], $params[1]);
            case 3:
            return $class->$method($params[0], $params[1], $params[2]);
            case 4:
            return $class->$method($params[0], $params[1], $params[2], $params[3]);
            default:
            call_user_func_array([$class, $method], $params);
        }
    }
}
