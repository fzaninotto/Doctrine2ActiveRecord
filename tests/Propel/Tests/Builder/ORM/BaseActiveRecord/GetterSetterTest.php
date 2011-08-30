<?php

namespace Propel\Tests\Builder\ORM\BaseActiveRecord;

use Propel\Builder\ORM\BaseActiveRecord;
use Propel\Builder\ORM\ActiveRecord;
use Doctrine\ORM\Mapping\ClassMetadataInfo;

class GetterSetterTest extends \PHPUnit_Framework_TestCase
{
    static public function setUpBeforeClass()
    {
        $metadata = new ClassMetadataInfo('Propel\\Tests\\Builder\\ORM\\BaseActiveRecord\\GetterSetterEntity');
        $metadata->setPrimaryTable(array('name' => 'author'));
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

    public function testDefaultValues()
    {
        $e = new GetterSetterEntity();
        $this->assertNull($e->getId());
        $this->assertNull($e->getFirstName());
        $this->assertEquals('no comment', $e->getComment());
    }

    public function testModifyValue()
    {
        $e = new GetterSetterEntity();
        $e->setId(123);
        $this->assertEquals(123, $e->getId());
        $e->setFirstName('Foo');
        $this->assertEquals('Foo', $e->getFirstName());
        $e->setComment('great');
        $this->assertEquals('great', $e->getComment());
    }

}
