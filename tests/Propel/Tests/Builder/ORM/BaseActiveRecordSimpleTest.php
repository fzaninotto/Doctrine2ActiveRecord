<?php

namespace Propel\Tests\Builder\ORM;

use Propel\Builder\ORM\BaseActiveRecord;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class BaseActiveRecordSimpleTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultMappingDriver()
    {
        $builder = new BaseActiveRecord(new ClassMetadataInfo('foo'));
        $this->assertTrue($builder->isMappingStaticPhp());
        $this->assertFalse($builder->isMappingAnnotation());
    }

    public function testStaticPhpMappingDriver()
    {
        $builder = new BaseActiveRecord(new ClassMetadataInfo('foo'));
        $builder->setMappingDriver(BaseActiveRecord::MAPPING_STATIC_PHP);
        $this->assertTrue($builder->isMappingStaticPhp());
        $this->assertFalse($builder->isMappingAnnotation());
    }
    
    public function testAnnotationsMappingDriver()
    {
        $builder = new BaseActiveRecord(new ClassMetadataInfo('foo'));
        $builder->setMappingDriver(BaseActiveRecord::MAPPING_ANNOTATION);
        $this->assertFalse($builder->isMappingStaticPhp());
        $this->assertTrue($builder->isMappingAnnotation());
    }

    public function testBothMappingDrivers()
    {
        $builder = new BaseActiveRecord(new ClassMetadataInfo('foo'));
        $builder->setMappingDriver(BaseActiveRecord::MAPPING_STATIC_PHP | BaseActiveRecord::MAPPING_ANNOTATION);
        $this->assertTrue($builder->isMappingStaticPhp());
        $this->assertTrue($builder->isMappingAnnotation());
    }

}