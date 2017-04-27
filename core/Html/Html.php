<?php

namespace Core\Html;

use Core\Utils\UrlGenerator;

/**
 * Standard HTML builder class.
 */
class Html extends BaseBuilder
{
    /**
     * URL Generator.
     *
     * @var \Core\Utils\UrlGenerator
     */
    private $_generator;

    /**
     * Ctor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->_generator = new UrlGenerator();
    }

    /**
     * Returns an asset. JS, CSS, image, or anything
     * from the assets directory.
     *
     * @param string $path
     *
     * @return string
     */
    public function asset($path)
    {
        return $this->_generator->asset($path);
    }

    /**
     * Returns a stylesheet HTML tag with given filename.
     *
     * @param string $file
     *
     * @return string
     */
    public function stylesheet($file)
    {
        $dirtypes = ['css', 'stylesheets', 'styles'];
        $asset = '';
        foreach ($dirtypes as $dir) {
            $ext = substr($file, strrpos($file, '.') + 1);
            $file = $file.(($ext != 'css') ? '.css' : '');
            $filepath = base_path().'/assets/'.$dir.'/'.$file;
            $asset = $this->_generator->asset($dir.'/'.$file);

            if (file_exists($filepath)) {
                break;
            } else {
                $asset = 'no stylesheet found';
            }
        }

        return '<link rel="stylesheet" type="text/css" href="'.$asset.'">';
    }

    /**
     * Returns a JavaScript tag with given filename.
     *
     * @param string $file
     *
     * @return string
     */
    public function script($file)
    {
        $dirtypes = ['js', 'javascript', 'scripts'];
        $asset = '';
        foreach ($dirtypes as $dir) {
            $ext = substr($file, strrpos($file, '.') + 1);
            $file = $file.(($ext != 'js') ? '.js' : '');
            $filepath = base_path().'/assets/'.$dir.'/'.$file;
            $asset = $this->_generator->asset($dir.'/'.$file);

            if (file_exists($filepath)) {
                break;
            } else {
                $asset = 'no script found';
            }
        }

        return '<script type="text/javascript" src="'.$asset.'"></script>';
    }

    /**
     * Returns a URL.
     *
     * @param string $path
     *
     * @return string
     */
    public function url($path)
    {
        return $this->_generator->to($path);
    }

    /**
     * Generates an anchor tag.
     *
     * @param string $url
     * @param string $content
     * @param array  $options
     * @param bool   $safe
     *
     * @return mixed
     */
    public function link($url, $content = '', $options = [], $safe = false)
    {
        if (is_null($content)) {
            $content = $url;
        }

        return '<a href="'.$this->_generator->generateUrl($url).'"'.self::attributes($options).'>'.self::encode($content, $safe).'</a>';
    }

    /**
     * Obfuscates an email address.
     *
     * @param string $email
     *
     * @return string
     */
    public function email($email)
    {
        return str_replace('@', '&#64;', self::obfuscate($email));
    }

    /**
     * Creates a mailto link while also obfuscating email address.
     *
     * @param string $email
     *
     * @return string
     */
    public function mailto($email)
    {
        $email = $this->email($email);

        return '<a href="mailto:'.$email.'">'.$email.'</a>';
    }

    /**
     * Creates an image element.
     *
     * @param string $url
     * @param string $alt
     * @param array  $options
     *
     * @return string
     */
    public function image($url, $alt = null, $options = [])
    {
        $options['alt'] = $alt;

        return '<img src="'.$this->_generator->asset($url).'"'.self::attributes($options).'>';
    }
}
