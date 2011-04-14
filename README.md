Doctrine2 ActiveRecord with Twig
================================

This is an experiment for building ActiveRecord functionality on top of Doctrine2 using the Twig templating engine. Whether it is called Propel2 or not is irrelevant.

Requirements
------------

To run the demo, you need to clone the following repositories:

 * [Doctrine2](https://github.com/doctrine/doctrine2) (for the ORM layer)
 * [Symfony2 ClassLoader component](https://github.com/symfony/ClassLoader)
 * [Twig](https://github.com/fabpot/Twig) (as templating engine)

Then, copy the `config.php-dist` into a `config.php` file, edit the paths to the libraries, and you're good to go.

Demo
----

From the root of the project, type:

    $ php tests/demo/demo.php

Features
--------

Not much for now. Although the builder architecture already allows for partial template customization and extentions (a.k.a behaviors).

Usage
-----

No command line utility for now. You need to build classes by hand using the builders.

Example build:

    <?php
    
    // register autoloaders, etc.
    
    use Propel\Builder\ORM\BaseActiveRecord;
    use Propel\Builder\ORM\ActiveRecord;
    use Propel\Builder\Extension\Timestampable;
    use Propel\Builder\Extension\GenerationTimestamp;
    use Doctrine\ORM\Mapping\ClassMetadataInfo;
    
    $metadata = new ClassMetadataInfo('Bookstore\\Book');
    $metadata->mapField(array('fieldName' => 'id', 'type' => 'integer', 'id' => true));
    $metadata->mapField(array('fieldName' => 'name', 'type' => 'string'));
    $metadata->mapField(array('fieldName' => 'status', 'type' => 'string', 'default' => 'published'));
    
    $builder = new BaseActiveRecord($metadata);
    echo $builder->getCode();

This generates the following code:

    <?php
    
    namespace Bookstore\Base;
    
    /**
     * Base class providing ActiveRecord features to Book.
     * Do not modify this class: it will be overwritten each time you regenerate ActiveRecord.
     */
    class Book
    {
    
        protected $id;
    
        protected $name;
    
        protected $status = 'published';
    
        /**
         * Get the id field value
         * @return mixed
         */
        public function getId()
        {
            return $this->id;
        }
    
        /**
         * Set the id field value
         * @param $id mixed
         */
        public function setId($id)
        {
            $this->id = $id;
        }
    
        /**
         * Get the name field value
         * @return mixed
         */
        public function getName()
        {
            return $this->name;
        }
    
        /**
         * Set the name field value
         * @param $name mixed
         */
        public function setName($name)
        {
            $this->name = $name;
        }
    
        /**
         * Get the status field value
         * @return mixed
         */
        public function getStatus()
        {
            return $this->status;
        }
    
        /**
         * Set the status field value
         * @param $status mixed
         */
        public function setStatus($status)
        {
            $this->status = $status;
        }
    
        /**
         * Load the metadata for a Doctrine\ORM\Mapping\Driver\StaticPHPDriver.
         *
         * @param \Doctrine\ORM\Mapping\ClassMetadata $metadata The metadata class.
         */
        static public function loadMetadata(\Doctrine\ORM\Mapping\ClassMetadata $metadata)
        {
            $metadata->setIdGeneratorType(\Doctrine\ORM\Mapping\ClassMetadata::GENERATOR_TYPE_NONE);
            $metadata->mapField(array(
                'fieldName' => 'id',
                'type' => 'integer',
                'columnName' => 'id',
                'id' => true,
            ));
            $metadata->mapField(array(
                'fieldName' => 'name',
                'type' => 'string',
                'columnName' => 'name',
            ));
            $metadata->mapField(array(
                'fieldName' => 'status',
                'type' => 'string',
                'columnName' => 'status',
            ));
        }
    
        static public function getEntityManager()
        {
            return \Propel\EntityManagerContainer::getEntityManager();
        }
    
       /**
         * Populates the object using an array.
         *
         * This is particularly useful when populating an object from one of the
         * request arrays (e.g. $_POST). This method goes through the column
         * names, checking to see whether a matching key exists in populated
         * array. If so the set[ColumnName]() method is called for that column.
         *
         * @param array $array An array to populate the object from.
         */
        public function fromArray($array)
        {
            if (isset($array['id'])) {
                $this->setId($array['id']);
            }
            if (isset($array['name'])) {
                $this->setName($array['name']);
            }
            if (isset($array['status'])) {
                $this->setStatus($array['status']);
            }
        }
    
        /**
         * Exports the object as an array.
         *
         * @return array An associative array containing the field names (as keys) and field values.
         */
        public function toArray()
        {
            return array(
                'id' => $this->getId(),
                'name' => $this->getName(),
                'status' => $this->getStatus(),
            );
        }
    
        /**
         * Returns if the entity is new.
         *
         * @return bool If the entity is new.
         */
        public function isNew()
        {
            return !static::getEntityManager()->getUnitOfWork()->isInIdentityMap($this);
        }
    
        /**
         * Returns if the entity is modified.
         *
         * @return bool If the entity is modified.
         */
        public function isModified()
        {
            return (bool) count($this->getModified());
        }
    
        /**
         * Returns the entity modifications
         *
         * @return array The entity modifications.
         */
        public function getModified()
        {
            if ($this->isNew()) {
                return array();
            }
    
            $originalData = static::getEntityManager()->getUnitOfWork()->getOriginalEntityData($this);
    
            return array_diff($originalData, $this->toArray());
        }
    
        /**
         * Refresh the entity from the database.
         *
         * @return void
         */
        public function reload()
        {
            static::getEntityManager()->getUnitOfWork()->refresh($this);
        }
    
        /**
         * Returns the change set of the entity.
         *
         * @return array The change set.
         */
        public function changeSet()
        {
            return static::getEntityManager()->getUnitOfWork()->getEntityChangeSet($this);
        }
    
        /**
         * Persist the current object and flush the entity manager
         */
        public function save()
        {
            $em = self::getEntityManager();
            $em->persist($this);
            $em->flush();
        }
    
        /**
         * Remove the current object and flush the entity manager
         */
        public function delete()
        {
            $em = self::getEntityManager();
            $em->remove($this);
            $em->flush();
        }
    
    }
