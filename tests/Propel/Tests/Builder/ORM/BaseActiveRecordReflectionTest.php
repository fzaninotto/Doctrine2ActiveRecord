<?php

namespace Propel\Tests\Builder\ORM;

use Propel\Builder\ORM\BaseActiveRecord;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Mapping\ClassMetadata;
use ReflectionClass;
use ReflectionProperty;

class BaseActiveRecordReflectionTest extends \PHPUnit_Framework_TestCase
{
    static public function setUpBeforeClass()
    {
        $metadata = new ClassMetadataInfo('Propel\\Tests\\Builder\\ORM\\Book');
        $metadata->mapField(array('fieldName' => 'id', 'type' => 'integer', 'id' => true));
        $metadata->mapField(array('fieldName' => 'name', 'type' => 'string', 'columnName' => 'foo_name', 'length' => 25, 'nullable' => true, 'columnDefinition' => 'Hello world'));
        $metadata->mapField(array('fieldName' => 'status', 'type' => 'integer', 'default' => 23, 'precision' => 2, 'scale' => 2, 'unique' => 'unique_status'));
        
        $builder = new BaseActiveRecord($metadata);
        eval('?>' . $builder->getCode());
    }
    
    public function testProperties()
    {
        $ref = new ReflectionClass(new Base\Book());
        $props = $ref->getProperties(ReflectionProperty::IS_PROTECTED);
        $this->assertEquals('id', $props[0]->getName());
        $this->assertEquals('name', $props[1]->getName());
        $this->assertEquals('status', $props[2]->getName());
    }
    
    public function testGetterSetter()
    {
        $ref = new ReflectionClass(new Base\Book());
        $this->assertTrue($ref->hasMethod('getId'));
        $this->assertTrue($ref->hasMethod('setId'));
        $this->assertTrue($ref->hasMethod('getName'));
        $this->assertTrue($ref->hasMethod('setName'));
        $this->assertTrue($ref->hasMethod('getStatus'));
        $this->assertTrue($ref->hasMethod('setStatus'));
    }
    
    public function testMetadadaGeneratorType()
    {
        $metadata = new ClassMetadata('Propel\\Tests\\Builder\\ORM\\Base\\Book');
        Base\Book::loadMetadata($metadata);
        $this->assertEquals(5, $metadata->generatorType);
    }

    public function testMetadataFieldMapping()
    {
        $metadata = new ClassMetadata('Propel\\Tests\\Builder\\ORM\\Base\\Book');
        Base\Book::loadMetadata($metadata);
        $expected = array(
            'id' =>
                array (
                'fieldName' => 'id',
                'type' => 'integer',
                'columnName' => 'id',
                'id' => true,
                ),
            'name' =>
                array (
                'fieldName' => 'name',
                'type' => 'string',
                'columnName' => 'foo_name',
                'length' => 25,
                'nullable' => true,
                'columnDefinition' => 'Hello world',
                ),
            'status' =>
                array (
                'fieldName' => 'status',
                'type' => 'integer',
                'columnName' => 'status',
                'precision' => 2,
                'scale' => 2,
                'unique' => 'unique_status',
                ),
        );
        $this->assertEquals($expected, $metadata->fieldMappings);
    }
    
    
}