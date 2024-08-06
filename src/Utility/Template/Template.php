<?php

namespace Feral\Core\Utility\Template;

/**
 * Convert template strings with variables
 */
class Template
{
    public function replace ($str, $values, $startDelim = '{', $endDelim = '}'): string
    {
        foreach ($values as $key => $value) {
            if (is_array($value)) {
                $value = '(array)';
            } elseif (is_object($value)) {
                $value = '(object)';
            }
            if (is_string($value) || is_numeric($value)) {
                $str = str_replace($startDelim . $key . $endDelim, $value, $str);
            }
        }
        return $str;
    }
}