<?php

namespace Propel\Tests\Builder\ORM;

use Propel\Tests\TestCase;
use Propel\Builder\ORM\BaseActiveRecord;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\UnitOfWork;

class BaseActiveRecordTest extends TestCase
{
    protected static $metadata;

    static public function setUpBeforeClass()
    {
        $metadata = new ClassMetadataInfo('Propel\\Tests\\Builder\\ORM\\Author');
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_AUTO);
        $metadata->mapField(array('fieldName' => 'id', 'type' => 'integer', 'id' => true));
        $metadata->mapField(array('fieldName' => 'firstName', 'type' => 'string'));
        $metadata->mapField(array('fieldName' => 'lastName', 'type' => 'string'));
        $metadata->mapField(array('fieldName' => 'comment', 'type' => 'string', 'default' => 'no comment'));
        $builder = new BaseActiveRecord($metadata);
        eval('?>' . $builder->getCode());
    }

    public function setUp()
    {
        parent::setUp();
        $this->entityManager->getConnection()->executeQuery('CREATE TABLE author(id INTEGER PRIMARY KEY,firstName VARCHAR(25),lastName VARCHAR(25),comment VARCHAR(25))');
    }

    public function testDefaultValues()
    {
        $author = new Base\Author();
        $this->assertNull($author->getId());
        $this->assertNull($author->getFirstName());
        $this->assertEquals('no comment', $author->getComment());
    }

    public function testModifyValue()
    {
        $author = new Base\Author();
        $author->setId(123);
        $this->assertEquals(123, $author->getId());
        $author->setFirstName('Foo');
        $this->assertEquals('Foo', $author->getFirstName());
        $author->setComment('great');
        $this->assertEquals('great', $author->getComment());
    }

    public function testGenericGetter()
    {
        $author = new Base\Author();
        $author->setId(123);
        $author->setFirstName('Foo');
        $this->assertEquals(123, $author->getByName('id'));
        $this->assertEquals('Foo', $author->getByName('firstName'));
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGenericGetterThrowsExceptionOnIncorrectProperty()
    {
        $author = new Base\Author();
        $this->assertEquals(123, $author->getByName('bliuoiui'));
    }

    public function testGenericSetter()
    {
        $author = new Base\Author();
        $author->setByName('id', 123);
        $author->setByName('firstName', 'Foo');
        $this->assertEquals(123, $author->getId());
        $this->assertEquals('Foo', $author->getFirstName());
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testGenericSetterThrowsExceptionOnIncorrectProperty()
    {
        $author = new Base\Author();
        $author->setByName('bliuoiui', 123);
    }

    public function testSave()
    {
        $author = new Base\Author();
        $this->assertEquals(UnitOfWork::STATE_NEW, $this->entityManager->getUnitOfWork()->getEntityState($author));
        $author->save();
        $this->assertNotNull($author->getId());
        $this->assertEquals(UnitOfWork::STATE_MANAGED, $this->entityManager->getUnitOfWork()->getEntityState($author));
    }

    public function testToArray()
    {
        $author = new Base\Author();
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
        $author = new Base\Author();
        $author->fromArray($array);
        $this->assertEquals(123, $author->getId());
        $this->assertEquals('Leo', $author->getFirstName());
        $this->assertNull($author->getLastName());
        $this->assertEquals('comment', $author->getComment());
    }

    public function testFromArrayNullValues()
    {
        $author = new Base\Author();
        $author->setFirstName('pablodip');
        $author->fromArray(array(
            'firstName' => null,
        ));
        $this->assertNull($author->getFirstName());
    }

    public function testIsNew()
    {
        $author = new Base\Author();
        $this->assertTrue($author->isNew());
        $author->save();
        $this->assertFalse($author->isNew());
    }

    public function testIsModified()
    {
        $author = new Base\Author();
        $this->assertFalse($author->isModified());
        $author->save();
        $this->assertFalse($author->isModified());
    }

}
