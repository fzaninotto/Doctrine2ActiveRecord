<?php

namespace Propel\Builder\ORM;

use Propel\Builder\ORM\ORMBuilder;

class BaseActiveRecord extends ORMBuilder
{
    public function getNamespace()
    {
        if ($namespace = parent::getNamespace()) {
            return $namespace . '\\Base';
        }
        return 'Base';
    }
}