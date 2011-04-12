<?php

namespace Propel\Builder;

use Propel\Builder\TwigBuilder;

class TwigExtension extends TwigBuilder
{   
    public function getTemplateSource($templateName)
    {
        $loader = new \Twig_Loader_Filesystem($this->getTemplateDirs());
        return $loader->getSource($templateName);
    }
    
    public function getTemplate()
    {
        return $this->getTemplateSource($this->getTemplateName());
    }
}