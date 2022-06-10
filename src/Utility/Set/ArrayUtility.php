<?php


namespace NoLoCo\Core\Utility\Set;

/**
 * Class ArrayUtility
 * @package NoLoCo\Core\Utility\Set
 */
class ArrayUtility
{
    /**
     * Search a multi dimensional array and return an array
     * of array which build a path to the value being searched.
     * @param string $needle
     * @param array $haystack
     * @return array
     */
    public function deepSearch(string $needle, array $haystack): array
    {
        $found = [];
        foreach ($haystack as $key => $value) {
            if ($needle === $value) {
                $found[] = array($key);
            } elseif (is_array($value)) {
                $results = $this->deepSearch($needle, $value);
                if ($results) {
                    $found[] = array_merge(array($key => $results));
                }
            }
        }
        return $found;
    }

    /**
     * Remove the values found in a map of keys. Return the array with the removed
     * values.
     * @param array $keyMap
     * @param array $haystack
     * @param bool $isMultipleKeyMap Set to true if multiple keymaps are being used.
     * @return array
     */
    public function deepRemoval(array $keyMap, array $haystack, bool $isMultipleKeyMap = false): array
    {
        if ($isMultipleKeyMap) {
            foreach ($keyMap as $keys) {
                $haystack = $this->deepRemoval($keys, $haystack);
            }
        } else {
            foreach ($keyMap as $key => $value) {
                if (is_array($value) && isset($haystack[$key])) {
                    $haystack[$key] = $this->deepRemoval($value, $haystack[$key]);
                } else {
                    if (isset($haystack[$value])) {
                        unset($haystack[$value]);
                    }
                }
            }
        }
        return $haystack;
    }
}
