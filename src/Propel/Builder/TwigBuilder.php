<?php

namespace Propel\Builder;

class TwigBuilder
{
    protected $templateDirs = array();
    protected $templateName;
    protected $twigFilters = array('var_export', 'ucfirst');
    protected $variables = array();
    
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
            $ref = new \ReflectionClass($this);
            $this->templateDirs = array(dirname($ref->getFileName()) . '/templates');
        }
        return $this->templateDirs;
    }
    
    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
    }
    
    public function getTemplateName()
    {
        if (null === $this->templateName) {
            $classParts = explode('\\', get_class($this));
            $simpleClassName = array_pop($classParts);
            $this->templateName = $simpleClassName . '.php';
        }
        return $this->templateName;
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
        $twig = new \Twig_Environment($loader, array('autoescape' => false, 'strict_variables' => true));
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
}