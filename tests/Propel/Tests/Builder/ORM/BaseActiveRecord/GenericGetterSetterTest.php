<?php

namespace Propel\Tests\Builder\ORM\BaseActiveRecord;

use Propel\Builder\ORM\BaseActiveRecord;
use Propel\Builder\ORM\ActiveRecord;
use Propel\Mapping\ClassMetadataInfo;

class GenericGetterSetterTest extends \PHPUnit_Framework_TestCase
{
    static public function setUpBeforeClass()
    {
        $metadata = new ClassMetadataInfo('Propel\\Tests\\Builder\\ORM\\BaseActiveRecord\\GenericGetterSetterEntity');
        $metadata->setTableName('author');
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_AUTO);
        $metadata->mapField(array('fieldName' => 'id', 'type' => 'integer', 'id' => true));
        $metadata->mapField(array('fieldName' => 'firstName', 'type' => 'string'));
        $metadata->mapField(array('fieldName' => 'lastName', 'type' => 'string'));
        $metadata->mapField(array('fieldName' => 'comment', 'type' => 'string', 'default' => 'no comment'));
        $builder = new BaseActiveRecord($metadata);
        eval('?>' . $builder->getCode());
        $builder = new ActiveRecord($metadata);
        eval('?>' . $builder->getCode());
    }

    public function testGenericGetter()
    {
        $e = new GenericGetterSetterEntity();
        $e->setId(123);
        $e->setFirstName('Foo');
        $this->assertEquals(123, $e->getByName('id'));
        $this->assertEquals('Foo', $e->getByName('firstName'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGenericGetterThrowsExceptionOnIncorrectProperty()
    {
        $e = new GenericGetterSetterEntity();
        $this->assertEquals(123, $e->getByName('bliuoiui'));
    }

    public function testGenericSetter()
    {
        $e = new GenericGetterSetterEntity();
        $e->setByName('id', 123);
        $e->setByName('firstName', 'Foo');
        $this->assertEquals(123, $e->getId());
        $this->assertEquals('Foo', $e->getFirstName());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGenericSetterThrowsExceptionOnIncorrectProperty()
    {
        $e = new GenericGetterSetterEntity();
        $e->setByName('bliuoiui', 123);
    }

}
