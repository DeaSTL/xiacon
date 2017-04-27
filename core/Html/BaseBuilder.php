<?php

namespace Core\Html;

/**
 * Base builder class for Form and HTML builders.
 */
class BaseBuilder
{
    /**
     * Cycles through given attributes and sets them for the element.
     *
     * @param array $attributes - The elements given options (attributes)
     *
     * @return string
     */
    protected function attributes($attributes = [])
    {
        $ar = [];

        foreach ($attributes as $key => $value) {
            $element = $this->attribute($key, $value);
            if (!is_null($element)) {
                $ar[] = $element;
            }
        }

        return count($ar) > 0 ? ' '.implode(' ', $ar) : '';
    }

    /**
     * Creates the attribute string.
     *
     * @param string $key   - The attribute's key
     * @param string $value - The $key's value
     *
     * @return string
     */
    protected function attribute($key, $value)
    {
        if (is_numeric($key)) {
            $key = $value;
        }

        if (!is_null($value)) {
            return $key.'="'.$value.'"';
        }
    }

    /**
     * Encodes a string using htmlentities.
     *
     * @param string $value - Value to be escaped
     * @param bool   $safe  - Do you want to encode?
     *
     * @return string
     */
    protected function encode($value, $safe = false)
    {
        return ($safe) ? htmlentities($value, ENT_QUOTES, 'UTF-8') : $value;
    }

    /**
     * Decodes an HTML encoded string.
     *
     * @param string $value - The string to decode
     *
     * @return string
     */
    protected function decode($value)
    {
        return html_entity_decode($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Obfuscates a string.
     *
     * @param string $value - The string to obfuscate
     *
     * @return string
     */
    public function obfuscate($value)
    {
        $safe = '';

        foreach (str_split($value) as $letter) {
            if (ord($letter) > 128) {
                return $letter;
            }

            switch (rand(1, 3)) {
                case 1:
                $safe .= '&#'.ord($letter).';';
                break;
                case 2:
                $safe .= '&#x'.dechex(ord($letter)).';';
                break;
                case 3:
                $safe .= $letter;
            }
        }

        return $safe;
    }
}
