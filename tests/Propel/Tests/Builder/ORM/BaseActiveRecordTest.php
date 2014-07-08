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
        $metadata->setPrimaryTable(array('name' => 'author'));
        $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_AUTO);
        $metadata->mapField(array('fieldName' => 'id', 'type' => 'integer', 'id' => true));
        $metadata->mapField(array('fieldName' => 'firstName', 'type' => 'string', 'nullable' => true));
        $metadata->mapField(array('fieldName' => 'lastName', 'type' => 'string', 'nullable' => true));
        $metadata->mapField(array('fieldName' => 'comment', 'type' => 'string', 'default' => 'no comment'));
        $builder = new BaseActiveRecord($metadata);
        eval('?>' . $builder->getCode());
        self::$metadata = $metadata;
    }

    public function setUp()
    {
        parent::setUp();
        $schemaTool = new SchemaTool($this->entityManager);
        $schemaTool->createSchema(array(self::$metadata));
    }

    public function testSave()
    {
        $author = new Base\Author();
        $this->assertEquals(UnitOfWork::STATE_NEW, $this->entityManager->getUnitOfWork()->getEntityState($author));
        $author->save();
        $this->assertNotNull($author->getId());
        $this->assertEquals(UnitOfWork::STATE_MANAGED, $this->entityManager->getUnitOfWork()->getEntityState($author));
    }

    public function testPersist()
    {
        $author = new Base\Author();
        $this->assertEquals(UnitOfWork::STATE_NEW, $this->entityManager->getUnitOfWork()->getEntityState($author));
        $author->persist();
        $this->assertNull($author->getId());
        $this->assertEquals(UnitOfWork::STATE_MANAGED, $this->entityManager->getUnitOfWork()->getEntityState($author));
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
