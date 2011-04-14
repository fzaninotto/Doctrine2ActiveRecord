<?php

/*
 * Copyright 2010 Pablo Díez Pascual <pablodip@gmail.com>
 */

namespace Propel\Tests;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Mapping\Driver\StaticPHPDriver;
use Propel\EntityManagerContainer;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $entityManager;

    protected $eventManager;

    protected $metadataFactory;

    public function setUp()
    {
        if (!$this->entityManager) {
            EntityManagerContainer::clearEntityManager();

            $configuration = new Configuration();
            $configuration->setMetadataDriverImpl(new StaticPHPDriver(__DIR__.'/../../Model'));
            $configuration->setProxyDir(__DIR__.'/../../Proxy');
            $configuration->setProxyNamespace('Proxy');
            $configuration->setAutoGenerateProxyClasses(true);

            $this->entityManager = EntityManager::create(array(
                'driver' => 'pdo_sqlite',
                'path'   => ':memory:',
            ), $configuration);

            // event manager
            $this->eventManager = $this->entityManager->getEventManager();

            // metadata factory
            $this->metadataFactory = $this->entityManager->getMetadataFactory();

            // create schema
            $schemaTool = new SchemaTool($this->entityManager);
            $schemaTool->createSchema($this->metadataFactory->getAllMetadata());

            // entity manager container
            EntityManagerContainer::setEntityManager($this->entityManager);
        }
    }
}
