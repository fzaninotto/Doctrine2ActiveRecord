<?php

namespace Propel\Builder\Extension;

use Propel\Builder\TwigExtension;

class Timestampable extends TwigExtension
{
    public function postSave()
    {
        return $this->getTemplateSource('preSave.php');
    }
}