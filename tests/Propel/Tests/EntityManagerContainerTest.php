<?php

/*
 * Copyright 2010 Pablo Díez Pascual <pablodip@gmail.com>
 */

namespace Propel\Tests;

use Propel\EntityManagerContainer as Container;

class CoreTest extends TestCase
{
    public function testEntityManager()
    {
        Container::clearEntityManager();
        $this->assertNull(Container::getEntityManager());

        Container::setEntityManager($this->entityManager);
        $this->assertSame($this->entityManager, Container::getEntityManager());

        Container::clearEntityManager();
        $this->assertNull(Container::getEntityManager());
    }
}
