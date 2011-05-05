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
        $metadata->mapOneToOne(array(
            'fieldName' => 'author',
            'targetEntity' => 'Doctrine\Tests\ORM\Tools\EntityGeneratorAuthor',
            'mappedBy' => 'book',
            'joinColumns' => array(
                array('name' => 'author_id', 'referencedColumnName' => 'id')
            ),
        ));
        $metadata->mapManyToMany(array(
            'fieldName' => 'comments',
            'targetEntity' => 'Doctrine\Tests\ORM\Tools\EntityGeneratorComment',
            'joinTable' => array(
                'name' => 'book_comment',
                'joinColumns' => array(array('name' => 'book_id', 'referencedColumnName' => 'id')),
                'inverseJoinColumns' => array(array('name' => 'comment_id', 'referencedColumnName' => 'id')),
            ),
        ));
        $builder = new BaseActiveRecord($metadata);
        eval('?>' . $builder->getCode());
    }

    public function testActiveEntity()
    {
        $b = new Base\Book();
        $this->assertInstanceOf('\\Propel\\ActiveEntity', $b);
    }
    
    public function testConstructorForAssociations()
    {
        $b = new Base\Book();
        $this->assertInstanceOf('\Doctrine\Common\Collections\ArrayCollection', $b->getComments());
    }
    
    public function testPropertiesForFields()
    {
        $ref = new ReflectionClass(new Base\Book());
        $this->assertTrue($ref->hasProperty('id'));
        $this->assertTrue($ref->hasProperty('name'));
        $this->assertTrue($ref->hasProperty('status'));
    }

    public function testPropertiesForAssociations()
    {
        $ref = new ReflectionClass(new Base\Book());
        $this->assertTrue($ref->hasProperty('author'));
        $this->assertFalse($ref->hasProperty('author_id'));
        $this->assertTrue($ref->hasProperty('comments'));
    }
    
    public function testGetterSetterForFields()
    {
        $ref = new ReflectionClass(new Base\Book());
        $this->assertTrue($ref->hasMethod('getId'));
        $this->assertTrue($ref->hasMethod('setId'));
        $this->assertTrue($ref->hasMethod('getName'));
        $this->assertTrue($ref->hasMethod('setName'));
        $this->assertTrue($ref->hasMethod('getStatus'));
        $this->assertTrue($ref->hasMethod('setStatus'));
    }

    public function testGetterSetterForAssociations()
    {
        $ref = new ReflectionClass(new Base\Book());
        $this->assertTrue($ref->hasMethod('getAuthor'));
        $this->assertTrue($ref->hasMethod('setAuthor'));
        $this->assertTrue($ref->hasMethod('getComments'));
        $this->assertTrue($ref->hasMethod('setComments'));
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
           'id' => array (
                'fieldName'  => 'id',
                'type'       => 'integer',
                'id'         => true,
                'columnName' => 'id',
           ),
           'name' => array (
                'fieldName'  => 'name',
                'type'       => 'string',
                'columnName' => 'foo_name',
                'length'     => 25,
                'nullable'   => true,
                'columnDefinition' => 'Hello world',
           ),
           'status' => array (
                'fieldName'  => 'status',
                'type'       => 'integer',
                'default'    => 23,
                'precision'  => 2,
                'scale'      => 2,
                'unique'     => 'unique_status',
                'columnName' => 'status',
           ),
        );

        $this->assertSame($expected, $metadata->fieldMappings);
    }
}
