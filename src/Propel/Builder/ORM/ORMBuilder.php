<?php

namespace Propel\Builder\ORM;

use Propel\Builder\TwigBuilder;
use Propel\Builder\TwigExtension;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class ORMBuilder extends TwigBuilder
{
    protected $metadata;
    protected $extensions = array();
    protected $regenerateIfExists = true;
    
    public function __construct(ClassMetadataInfo $metadata)
    {
        $this->metadata = $metadata;

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
        $this->addTemplateDir($this->tmpDir);
        foreach ($this->extensions as $rank => $extension) {
            if ($rank) {
                $prefix = "{% extends '" . $this->getTempTemplateName($rank -1) . "' %}\n";
            } else {
                $prefix = "{% extends '" . $this->getTrueTemplateName() . "' %}\n";
            }
            $name = $this->getTempTemplateName($rank);
            file_put_contents($this->tmpDir . '/' . $name, $prefix . $extension->getTemplate());
            $variables = array_merge($variables, $extension->getVariables());
        }
        return parent::getCode($variables);
    }
    
    public function getRelativeFilePath()
    {
        return str_replace('\\', DIRECTORY_SEPARATOR, $this->getNamespace()) . DIRECTORY_SEPARATOR . $this->getClassName() . '.php';
    }
    
    /**
     * Generated and write class to disk
     *
     * @param string $outputDirectory 
     * @param array  $variables
     */
    public function writeClass($outputDirectory, $variables = array())
    {
        $path = $outputDirectory . DIRECTORY_SEPARATOR . $this->getRelativeFilePath();
        $dir = dirname($path);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (!file_exists($path) || (file_exists($path) && $this->regenerateIfExists)) {
            file_put_contents($path, $this->getCode($variables));
        }
    }
    
}