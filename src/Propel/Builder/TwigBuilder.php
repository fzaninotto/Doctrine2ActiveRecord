<?php

namespace Propel\Builder;

class TwigBuilder
{
    protected $templateDirs = array();
    protected $templateName;
    protected $twigFilters = array('var_export', 'ucfirst');
    protected $variables = array();
    protected $tmpDir;
    
    public function __construct()
    {
        $this->tmpDir = sys_get_temp_dir().'/Propel2';
        if (!is_dir($this->tmpDir)) {
            mkdir($this->tmpDir, 0777, true);
        }
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
        if (!$this->templateDirs) {
            $this->templateDirs = $this->getDefaultTemplateDirs();
        }
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
        if (null === $this->templateName) {
            $this->templateName = $this->getDefaultTemplateName();
        }
        return $this->templateName;
    }
    
    public function getDefaultTemplateName()
    {
        $classParts = explode('\\', get_class($this));
        $simpleClassName = array_pop($classParts);
        return $simpleClassName . '.php';
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
            'cache'            => $this->tmpDir,
        ));
        $this->addTwigFilters($twig);
        $template = $twig->loadTemplate($this->getTemplateName());
        $variables = array_merge($this->getVariables(), $variables);
        return $template->render($variables);
    }
    
    public function addTwigFilters(\Twig_Environment $twig)
    {
        foreach ($this->twigFilters as $twigFilter) {
            $twig->addFilter($twigFilter, new \Twig_Filter_Function($twigFilter));
        }
    }

    public function __destruct()
    {
        if ($this->tmpDir && is_dir($this->tmpDir)) {
            $this->removeDir($this->tmpDir);
        }
    }

    private function removeDir($target)
    {
        $fp = opendir($target);
        while (false !== $file = readdir($fp)) {
            if (in_array($file, array('.', '..'))) {
                continue;
            }

            if (is_dir($target.'/'.$file)) {
                self::removeDir($target.'/'.$file);
            } else {
                unlink($target.'/'.$file);
            }
        }
        closedir($fp);
        rmdir($target);
    }
}
