<?php

namespace Propel\Util;

class ORM
{
    /**
     * Convert Doctrine's type to PHP's
     *
     * @see http://www.doctrine-project.org/docs/orm/2.0/en/reference/basic-mapping.html#doctrine-mapping-types
     * @see http://www.php.net/manual/en/language.types.intro.php
     * 
     * @param string $type
     * 
     * @return string
     */
    static public function typeToPhp($type)
    {
        $types = array(
            'string'   => 'string',
            'integer'  => 'integer',
            'smallint' => 'integer',
            'bigint'   => 'string',
            'boolean'  => 'boolean',
            'decimal'  => 'float',
            'date'     => '\DateTime',
            'time'     => '\DateTime',
            'datetime' => '\DateTime',
            'text'     => 'string',
            'object'   => 'object',
            'array'    => 'object',
            'float'    => 'float',
        );

        return $types[$type];
    }
}
