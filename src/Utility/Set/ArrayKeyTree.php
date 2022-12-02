<?php

namespace NoLoCo\Core\Utility\Set;

/**
 * Class IdTree
 * Use a deep array structure to store a long key. Store each
 * character at a time.
 *
 * @package App\Data\Utilities
 */
class ArrayKeyTree implements KeyStorageInterface
{
    /**
     * An array key used to store if this node is a key
     */
    const KEY = '_k';

    /**
     * We will store the ids using an array that stores each
     * value one character at a time.
     *
     * @var array
     */
    protected array $arrayTree = [];

    /**
     * @inheritDoc
     */
    public function add(string $key): KeyStorageInterface
    {
        $currentPlace = & $this->arrayTree;
        $chars = str_split($key);
        while ($char = array_shift($chars)) {
            if (!isset($currentPlace[$char][self::KEY])) {
                $currentPlace[$char][self::KEY] = false;
            }
            $currentPlace = &$currentPlace[$char];
        }
        $currentPlace[self::KEY] = true;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function has(string $key): bool
    {
        $currentPlace = & $this->arrayTree;
        $chars = str_split($key);
        while ($char = array_shift($chars)) {
            if (isset($currentPlace[$char][self::KEY])) {
                $currentPlace = & $currentPlace[$char];
            } else {
                return false;
            }
        }
        return isset($currentPlace[self::KEY]) && $currentPlace[self::KEY];
    }
}
