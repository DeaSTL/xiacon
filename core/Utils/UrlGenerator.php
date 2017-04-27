<?php

namespace Core\Utils;

class UrlGenerator
{
    /**
     * Generates a URL for local or remote assets.
     *
     * @param string $url - URL to make generation from
     *
     * @return string
     */
    public function asset($url)
    {
        if ($this->isValidUrl($url)) {
            return $url;
        }

        return $this->generateUrl('/assets/'.$url);
    }

    /**
     * Checks if a given URL is a valid one.
     *
     * @param string $url - URL to check
     *
     * @return bool
     */
    public function isValidUrl($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    /**
     * Returns the basepath of the application.
     *
     * @return string
     */
    public function getRoot()
    {
        return env('BASEPATH', '/');
    }

    /**
     * Generates a URL useful for anchor tags.
     *
     * @param string $url - URL to generate from
     *
     * @return string
     */
    public function to($url)
    {
        if ($url == '/' && $this->getRoot() == $url) {
            return $url;
        }

        return $this->isValidUrl($url) ? $url : $this->generateUrl($url);
    }

    /**
     * Redirect to given URL.
     *
     * @param string $url - URL to generate from
     *
     * @return void
     */
    public function redirect($url)
    {
        if (!$this->isValidUrl($url)) {
            $url = $this->generateUrl($url);
        }

        header('Location: '.$url);
    }

    /**
     * Used to generate a URL based on relative or absolute.
     *
     * @param string $url - URL to generate from
     *
     * @return string
     */
    public function generateUrl($url)
    {
        $extern = false;
        if ((0 === strrpos($url, 'http://'))
            || (0 === strrpos($url, 'https://'))) {
            $extern = true;
        }

        $http = (isset($_SERVER['HTTPS'])) ? 'https://' : 'http://';

        if (!$extern) {
            return ($this->getRoot() == '/')
                ? (($this->getRoot() == $url) ? '' : $url) : $http.$_SERVER['SERVER_NAME'].$this->getRoot().$url;
        } else {
            return $url;
        }
    }
}
