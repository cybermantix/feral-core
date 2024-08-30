<?php

namespace Feral\Core\Utility\Template;

use Feral\Core\Process\NodeCode\Traits\ContextValueTrait;
use Feral\Core\Utility\Search\DataPathReader;

/**
 * Convert template strings with variables
 */
class Template
{
    private DataPathReader $reader;
    const DOES_NOT_EXIST = '_DNE_';

    public function __construct()
    {
        $this->reader = new DataPathReader();$this->reader = new DataPathReader();
    }

    public function replace ($str, $values, $startDelim = '{', $endDelim = '}'): string
    {
        $pattern = '/' . preg_quote($startDelim) . '([^' . preg_quote($endDelim) . ']*)' . preg_quote($endDelim)  . '/';
        preg_match_all($pattern, $str, $matches);
        foreach ($matches[1] as $match) {
            $value = $this->reader->get($values, $match);
            if (empty($value)) {
                $value = self::DOES_NOT_EXIST;
            }
            $str = str_replace($startDelim . $match . $endDelim, $value, $str);
        }
        return $str;
    }
}