Doctrine2 ActiveRecord with Twig
================================

This is an experiment for building ActiveRecord functionality on top of Doctrine2 using the Twig templating engine.

Requirements
------------

To run the demo, you need to clone the following repositories:

 * [Doctrine2](https://github.com/doctrine/doctrine2) (for the ORM layer)
 * [Symfony2](https://github.com/symfony/symfony) (for the universal autoloader)
 * [Twig](https://github.com/fabpot/Twig) (as templating engine)

Then, copy the `config.php-dist` into a `config.php` file, edit the paths to the libraries, and you're good to go.

Demo
----

From the root of the project, type:

    $ php tests/demo.php

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
    // using custom templates to tweak EntityManager
    $builder->addTemplateDir(__DIR__ . '/templates');
    // using extensions
    $builder->addExtension(new Timestampable());
    $builder->addExtension(new GenerationTimestamp());
    echo $builder->getCode();
