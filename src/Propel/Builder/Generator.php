<?php

namespace Propel\Builder;

class Generator
{
    protected $tempDir;
    protected $builders = array();
    
    public function __construct()
    {
        $this->tempDir = sys_get_temp_dir().'/Propel2';
        if (!is_dir($this->tempDir)) {
            mkdir($this->tempDir, 0777, true);
        }
    }

    public function __destruct()
    {
        if ($this->tempDir && is_dir($this->tempDir)) {
            $this->removeDir($this->tempDir);
        }
    }
    
    public function getBuilders()
    {
        return $this->builders;
    }
    
    public function addBuilder($builder)
    {
        $builder->setTempDir($this->tempDir);
        $this->builders[]= $builder;
    }
    
    /**
     * Generated and write classes to disk
     *
     * @param string $outputDirectory 
     * @param array  $variables
     */
    public function writeClasses($outputDirectory)
    {
        foreach ($this->builders as $builder) {
            /* @var $builder \Propel\Builder\ORM\BaseActiveRecord */

            $builder->writeClass($outputDirectory);
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
