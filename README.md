Doctrine2 ActiveRecord with Twig
================================

This is an experiment for building ActiveRecord functionality on top of Doctrine2 using the Twig templating engine. Whether it is called Propel2 or not is irrelevant.

Installation
------------

Clone the Propel2 repository:

    $ git clone --recursive https://github.com/fzaninotto/Propel2.git

Or if you use an old version of Git (pre 1.6.5):

    $ git clone https://github.com/fzaninotto/Propel2.git
    $ cd Propel2
    $ git submodule update --init --recursive

You're good to go.

Demo
----

From the root of the project, type:

    $ php tests/demo/demo.php

This outputs the generated code for a Base ActiveRecord class, based on a `Doctrine\ORM\Mapping\ClassMetadataInfo` instance.

To see the classes generated for XML mappings, you can also type:

    $ php tests/demo/demoFromXML.php

The classes are generated under set in `tests/demo/Model/`, based on the metadata set under `tests/demo/schema/`.

Features
--------

 * Working ActiveRecord builder (no handling of relations for now)
   * Generated entities are empty classes extending generated Base Entities extending nothing
   * Getter & setter generation
   * Metadata loader
   * Access to the EntityManager from within an Entity
   * fromArray and toArray
   * isNew, isModified, etc.
   * ActiveEntity methods: save(), delete()
 * Basic behavior support
   * Ability to alter the data structure
   * Ability to modify the generated code pretty much everywhere
   * Timestampable behavior example
 * Template customization via partials

Usage
-----

No command line utility for now. You need to build classes by hand using the builders.

Example build:

``` php
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
// more metadata description...

$builder = new BaseActiveRecord($metadata);
echo $builder->getCode();
```

This generates the following code:

``` php
<?php


namespace Bookstore\Base;

use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Base class providing ActiveRecord features to Book.
 * Do not modify this class: it will be overwritten each time you regenerate ActiveRecord.
 */
class Book 
{

    /**
     * @var string $name 
     */
    protected $name;

    /**
     * @var string $status 
     */
    protected $status = 'published';

    /**
     * @var integer $id 
     */
    protected $id;

    /**
     * @var \Doctrine\Tests\ORM\Tools\EntityGeneratorAuthor $author
     */
    protected $author;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection $comments
     */
    protected $comments;

    /**
     * Class constructor.
     * Initializes -to-many associations
     */
    public function __construct()
    {
        $this->comments = new ArrayCollection();
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
     * Get the author association value
     * @return \Doctrine\Tests\ORM\Tools\EntityGeneratorAuthor The related entity
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set the author association value
     * @param \Doctrine\Tests\ORM\Tools\EntityGeneratorAuthor $author The related entity
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Get the comments association value
     * @return \Doctrine\Common\Collections\ArrayCollection The collection of related entities
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set the comments association value
     * @param \Doctrine\Common\Collections\ArrayCollection $comments The collection of related entities
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * Set a property of the entity by name passed in as a string.
     *
     * @param string $name  The property name.
     * @param mixed  $value The value.
     *
     * @throws \InvalidArgumentException If the property does not exists.
     */
    public function setByName($name, $value)
    {
        if ('name' == $name) {
            return $this->setName($value);
        }
        if ('status' == $name) {
            return $this->setStatus($value);
        }
        if ('id' == $name) {
            return $this->setId($value);
        }

        throw new \InvalidArgumentException(sprintf('The property "%s" does not exists.', $name));
    }

    /**
     * Retrieve a property from the entity by name passed in as a string.
     *
     * @param string $name  The property name.
     *
     * @return mixed The value.
     *
     * @throws \InvalidArgumentException If the property does not exists.
     */
    public function getByName($name)
    {
        if ('name' == $name) {
            return $this->getName();
        }
        if ('status' == $name) {
            return $this->getStatus();
        }
        if ('id' == $name) {
            return $this->getId();
        }

        throw new \InvalidArgumentException(sprintf('The property "%s" does not exists.', $name));
    }

    /**
     * Load the metadata for a Doctrine\ORM\Mapping\Driver\StaticPHPDriver.
     *
     * @param ClassMetadata $metadata The metadata class.
     */
    static public function loadMetadata(ClassMetadata $metadata)
    {
        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_AUTO);
        $metadata->setChangeTrackingPolicy(ClassMetadata::CHANGETRACKING_DEFERRED_EXPLICIT);
        $metadata->setCustomRepositoryClass('Bookstore\BookRepository');
        $metadata->setPrimaryTable(array(
            'name' => 'book',
        ));
        $metadata->mapField(array(
            'fieldName'  => 'name',
            'type'       => 'string',
            'columnName' => 'name',
        ));
        $metadata->mapField(array(
            'fieldName'  => 'status',
            'type'       => 'string',
            'columnName' => 'status',
        ));
        $metadata->mapField(array(
            'fieldName'  => 'id',
            'type'       => 'integer',
            'columnName' => 'id',
            'id'         => true,
        ));
        $metadata->mapOneToOne(array(
            'fieldName'    => 'author',
            'targetEntity' => 'Doctrine\Tests\ORM\Tools\EntityGeneratorAuthor',
            'mappedBy'     => 'book',
            'cascade'      => array(),
            'fetch'        => ClassMetadata::FETCH_LAZY,
            'joinColumns'  => array(
                0 => array(
                    'name' => 'author_id',
                    'referencedColumnName' => 'id',
                    'unique' => true,
                ),
            ),
        ));
        $metadata->mapManyToMany(array(
            'fieldName'    => 'comments',
            'targetEntity' => 'Doctrine\Tests\ORM\Tools\EntityGeneratorComment',
            'cascade'      => array(),
            'fetch'        => ClassMetadata::FETCH_LAZY,
            'joinTable'    => array(
                'name' => 'book_comment',
                'joinColumns' => array(
                    0 => array(
                        'name' => 'book_id',
                        'referencedColumnName' => 'id',
                    ),
                ),
                'inverseJoinColumns' => array(
                    0 => array(
                        'name' => 'comment_id',
                        'referencedColumnName' => 'id',
                    ),
                ),
            ),
        ));
        $metadata->setLifecycleCallbacks(array(
            'postLoad' => array(
                0 => 'loading',
            ),
            'preRemove' => array(
                0 => 'willBeRemoved',
            ),
        ));
    }

    /**
     * Get the entity manager for this class
     */
    static public function getEntityManager()
    {
        return \EntityManagerContainer::getContainer();
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
        if (isset($array['name'])) {
            $this->setName($array['name']);
        }
        if (isset($array['status'])) {
            $this->setStatus($array['status']);
        }
        if (isset($array['id'])) {
            $this->setId($array['id']);
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
            'name' => $this->getName(),
            'status' => $this->getStatus(),
            'id' => $this->getId(),
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
```