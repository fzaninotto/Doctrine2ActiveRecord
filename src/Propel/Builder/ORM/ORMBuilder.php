<?php

namespace Propel\Builder\ORM;

use Propel\Builder\TwigBuilder;
use Propel\Builder\TwigExtension;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class ORMBuilder extends TwigBuilder
{
    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadataInfo
     */
    protected $metadata;

    protected $extensions = array();
    
    public function __construct(ClassMetadataInfo $metadata)
    {
        $this->metadata = $metadata;
        $this->outputName = str_replace('\\', DIRECTORY_SEPARATOR, $this->getNamespace()) . DIRECTORY_SEPARATOR . $this->getClassName() . '.php';

        parent::__construct();
    }
    
    public function getMetadada()
    {
        return $this->metadata;
    }

    public function getNamespace()
    {
        $name = $this->metadata->name;
        return substr($name, 0, strrpos($name, '\\'));
    }

    public function getClassName()
    {
        $name = $this->metadata->name;
        return ($pos = strrpos($name, '\\')) ? substr($name, $pos + 1, strlen($name)) : $name;
    }
    
    public function getVariables()
    {
        return array(
            'metadata'  => $this->metadata,
            'namespace' => $this->getNamespace(),
            'classname' => $this->getClassName(),
            'builder'   => $this
        );
    }
    
    public function addExtension(TwigExtension $extension)
    {
        $this->extensions[]= $extension;
    }
    
    public function getTrueTemplateName()
    {
        return parent::getTemplateName();
    }
    
    public function getTemplateName()
    {
        if (!$this->extensions) {
            return $this->getTrueTemplateName();
        }
        return $this->getTempTemplateName(count($this->extensions)-1);
    }
    
    protected function getTempTemplateName($number)
    {
        return 'Temp' . ($number) . '_' . $this->getTrueTemplateName();
    }
    
    public function getCode($variables = array())
    {
        $this->addTemplateDir($this->tempDir);
        foreach ($this->extensions as $rank => $extension) {
            if ($rank) {
                $prefix = "{% extends '" . $this->getTempTemplateName($rank -1) . "' %}\n";
            } else {
                $prefix = "{% extends '" . $this->getTrueTemplateName() . "' %}\n";
            }
            $name = $this->getTempTemplateName($rank);
            file_put_contents($this->tempDir . '/' . $name, $prefix . $extension->getTemplate());
            $variables = array_merge($variables, $extension->getVariables());
        }
        return parent::getCode($variables);
    }
    
}