<?php

namespace Cascada\CoreBundle\Utilities;

class ArrayUtilities
{
    /**
     * Picks element from array by keys.
     *
     * @param array $keys
     * @param array $subject
     *
     * @return array
     */
    public static function pick(array $keys, array $subject)
    {
        $result = [];

        foreach ($keys as $key) {
            if (array_key_exists($key, $subject)) {
                $result[$key] = $subject[$key];
            }
        }

        return $result;
    }
}