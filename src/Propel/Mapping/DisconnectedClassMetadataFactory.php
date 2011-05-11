<?php

namespace Propel\Mapping;

use Propel\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory as BaseDisconnectedClassMetadataFactory;

/**
 * workaround for http://www.doctrine-project.org/jira/browse/DDC-1141 
 */
class DisconnectedClassMetadataFactory extends BaseDisconnectedClassMetadataFactory
{
    /**
     * @override
     */
    protected function newClassMetadataInstance($className)
    {
        $metadata = new ClassMetadataInfo($className);
        if (strpos($className, "\\") !== false) {
            $metadata->namespace = strrev(substr( strrev($className), strpos(strrev($className), "\\")+1 ));
        } else {
            $metadata->namespace = "";
        }
        return $metadata;
    }
}