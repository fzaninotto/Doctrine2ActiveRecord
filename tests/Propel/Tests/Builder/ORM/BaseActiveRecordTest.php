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
    
    public function testSave()
    {
        $author = new Base\Author();
        $this->assertEquals(UnitOfWork::STATE_NEW, $this->entityManager->getUnitOfWork()->getEntityState($author));
        $author->save();
        $this->assertNotNull($author->getId());
        $this->assertEquals(UnitOfWork::STATE_MANAGED, $this->entityManager->getUnitOfWork()->getEntityState($author));
    }
    
}