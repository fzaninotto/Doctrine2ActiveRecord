<?php

namespace Propel\Mapping;

use Doctrine\ORM\Mapping\ClassMetadataInfo as BaseClassMetadataInfo;

/**
 * workaround for http://www.doctrine-project.org/jira/browse/DDC-1141 
 */
class ClassMetadataInfo extends BaseClassMetadataInfo
{
    /**
     * Gets the (possibly quoted) primary table name of this class for safe use
     * in an SQL statement.
     * 
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getQuotedTableName($platform)
    {
        return isset($this->table['quoted']) ?
                $platform->quoteIdentifier($this->table['name']) :
                $this->table['name'];
    }

    /**
     * Gets the (possibly quoted) column name of a mapped field for safe use
     * in an SQL statement.
     * 
     * @param string $field
     * @param AbstractPlatform $platform
     * @return string
     */
    public function getQuotedColumnName($field, $platform)
    {
        return isset($this->fieldMappings[$field]['quoted']) ?
                $platform->quoteIdentifier($this->fieldMappings[$field]['columnName']) :
                $this->fieldMappings[$field]['columnName'];
    }
}