<?php

namespace Propel;

use Doctrine\ORM\EntityManager;

/**
 * A container for the entity manager.
 *
 * @package Propel
 * @author  Pablo Díez Pascual <pablodip@gmail.com>
 */
class EntityManagerContainer
{
    static protected $entityManager;

    /**
     * Set the entity manager.
     *
     * @param \Doctrine\ORM\EntityManager $entityManager The entity manager.
     *
     * @return void
     */
    static public function setEntityManager(EntityManager $entityManager)
    {
        static::$entityManager = $entityManager;
    }

    /**
     * Returns the entity manager.
     *
     * @return \Doctrine\ORM\EntityManager The entity manager.
     */
    static public function getEntityManager()
    {
        return static::$entityManager;
    }

    /**
     * Clear the entity manager.
     *
     * @return void
     */
    static public function clearEntityManager()
    {
        static::$entityManager = null;
    }
}
