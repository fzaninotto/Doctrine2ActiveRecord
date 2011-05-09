<?php

namespace Propel\Builder;

use Propel\Util\Inflector;

class TwigBuilder
{
    protected $templateDirs = array();
    protected $templateName;
    protected $twigFilters = array(
        'var_export',
        'ucfirst',
        '\Doctrine\Common\Util\Inflector::classify',
        'substr',
        '\Propel\Util\ArrayType::stringify',
        '\Propel\Util\Inflector::singularize',
        '\Propel\Util\ORM::typeToPhp',
    );
    protected $variables = array();
    protected $tempDir;
    protected $mustOverwriteIfExists = true;
    protected $outputName;
    
    public function __construct()
    {
        $this->templateDirs = $this->getDefaultTemplateDirs();
        $this->templateName = $this->getDefaultTemplateName();
        $this->tempDir = sys_get_temp_dir();
    }
    
    public function setTempDir($tempDir)
    {
        $this->tempDir = $tempDir;
    }
    
    public function addTemplateDir($templateDir)
    {
        $dirs = $this->getTemplateDirs();
        array_unshift($dirs, $templateDir);
        $this->templateDirs = $dirs;
    }
    
    public function setTemplateDirs($templateDirs)
    {
        $this->templateDirs = $templateDirs;
    }

    public function getTemplateDirs()
    {
        return $this->templateDirs;
    }
    
    public function getDefaultTemplateDirs()
    {
        $ref = new \ReflectionClass($this);
        return array(dirname($ref->getFileName()) . '/templates');
    }
    
    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
    }
    
    public function getTemplateName()
    {
        return $this->templateName;
    }
    
    public function getDefaultTemplateName()
    {
        $classParts = explode('\\', get_class($this));
        $simpleClassName = array_pop($classParts);
        return $simpleClassName . '.php.twig';
    }
    
    public function setOutputName($outputName)
    {
        $this->outputName = $outputName;
    }

    public function getOutputName()
    {
        return $this->outputName;
    }
    
    public function mustOverwriteIfExists()
    {
        return $this->mustOverwriteIfExists;
    }
    
    public function setVariables($variables = array())
    {
        $this->variables = $variables;
    }
    
    public function getVariables()
    {
        return $this->variables;
    }
    
    public function getCode($variables = array())
    {
        $loader = new \Twig_Loader_Filesystem($this->getTemplateDirs());
        $twig = new \Twig_Environment($loader, array(
            'autoescape'       => false,
            'strict_variables' => true,
            'debug'            => true,
            'cache'            => $this->tempDir,
        ));
        $this->addTwigFilters($twig);
        $template = $twig->loadTemplate($this->getTemplateName());
        $variables = array_merge($this->getVariables(), $variables);
        return $template->render($variables);
    }

    /**
     * Generated and write class to disk
     *
     * @param string $outputDirectory 
     * @param array  $variables
     */
    public function writeClass($outputDirectory, $variables = array())
    {
        $path = $outputDirectory . DIRECTORY_SEPARATOR . $this->getOutputName();
        $dir = dirname($path);

        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }

        if (!file_exists($path) || (file_exists($path) && $this->mustOverwriteIfExists)) {
            file_put_contents($path, $this->getCode($variables));
        }
    }
    
    public function addTwigFilters(\Twig_Environment $twig)
    {
        foreach ($this->twigFilters as $twigFilter) {
            if (($pos = strpos($twigFilter, ':')) !== false) {
                $twigFilterName = substr($twigFilter, $pos + 2);
            } else {
                $twigFilterName = $twigFilter;
            }
            $twig->addFilter($twigFilterName, new \Twig_Filter_Function($twigFilter));
        }
    }
}
