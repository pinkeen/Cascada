<?php

namespace Cascada\CoreBundle\Utilities;

/**
 * Various string utilities.
 */
class StringUtilities 
{
    /**
     * Humanizes a camelcase string.
     *
     * @param string $text
     * @return string
     */
    public static function humanize($text)
    {
        return ucfirst(strtolower(preg_replace('/([a-z0-9])([A-Z])/', '$1 $2', $text)));
    }
} 