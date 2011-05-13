<?php

namespace Propel\Tests\Builder\ORM\BaseActiveRecord;

use Propel\Builder\ORM\BaseActiveRecord;
use Propel\Builder\ORM\ActiveRecord;
use Propel\Mapping\ClassMetadataInfo;

class ArrayConverterTest extends \PHPUnit_Framework_TestCase
{
    static public function setUpBeforeClass()
    {
        $metadata = new ClassMetadataInfo('Propel\\Tests\\Builder\\ORM\\BaseActiveRecord\\ArrayConverterEntity');
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

    public function testToArray()
    {
        $author = new ArrayConverterEntity();
        $author->setId(123);
        $author->setFirstName('Leo');
        $author->setLastName('Tolstoi');
        $expected = array(
            'id' => 123,
            'firstName' => 'Leo',
            'lastName' => 'Tolstoi',
            'comment' => 'no comment',
        );
        $this->assertEquals($expected, $author->toArray());
    }

    public function testFromArray()
    {
        $array = array(
            'id' => 123,
            'firstName' => 'Leo',
            'comment' => 'comment',
        );
        $author = new ArrayConverterEntity();
        $author->fromArray($array);
        $this->assertEquals(123, $author->getId());
        $this->assertEquals('Leo', $author->getFirstName());
        $this->assertNull($author->getLastName());
        $this->assertEquals('comment', $author->getComment());
    }

    public function testFromArrayNullValues()
    {
        $author = new ArrayConverterEntity();
        $author->setFirstName('pablodip');
        $author->fromArray(array(
            'firstName' => null,
        ));
        $this->assertNull($author->getFirstName());
    }

}
