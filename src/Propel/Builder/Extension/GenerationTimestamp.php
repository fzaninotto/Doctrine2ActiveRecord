<?php

namespace Propel\Builder\Extension;

use Propel\Builder\TwigExtension;

class GenerationTimestamp extends TwigExtension
{  
    public function getVariables()
    {
        $date = new \DateTime();
        return array('timestamp' => $date->format('Y-m-d H:i:s'));
    }
    
}