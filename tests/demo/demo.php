<?php

require_once __DIR__ . '/../../autoload.php';

use Propel\Builder\ORM\BaseActiveRecord;
use Propel\Builder\ORM\ActiveRecord;
use Propel\Builder\Extension\Timestampable;
use Propel\Builder\Extension\GenerationTimestamp;
use Doctrine\ORM\Mapping\ClassMetadataInfo;


$metadata = new ClassMetadataInfo('Bookstore\\Book');
$metadata->namespace = 'Bookstore';
$metadata->customRepositoryClassName = 'Bookstore\BookRepository';
$metadata->table['name'] = 'book';

$metadata->mapField(array(
    'fieldName' => 'id',
    'type'      => 'integer',
    'id'        => true,
));
$metadata->mapField(array(
    'fieldName' => 'name',
    'type'      => 'string',
));
$metadata->mapField(array(
    'fieldName' => 'status',
    'type'      => 'string',
    'default'   => 'published',
));

$metadata->mapOneToOne(array(
    'fieldName' => 'author',
    'targetEntity' => 'Doctrine\Tests\ORM\Tools\EntityGeneratorAuthor',
    'mappedBy' => 'book',
    'joinColumns' => array(
        array('name' => 'author_id', 'referencedColumnName' => 'id')
    ),
));
$metadata->mapManyToMany(array(
    'fieldName' => 'comments',
    'targetEntity' => 'Doctrine\Tests\ORM\Tools\EntityGeneratorComment',
    'joinTable' => array(
        'name' => 'book_comment',
        'joinColumns' => array(array('name' => 'book_id', 'referencedColumnName' => 'id')),
        'inverseJoinColumns' => array(array('name' => 'comment_id', 'referencedColumnName' => 'id')),
    ),
));
$metadata->addLifecycleCallback('loading', 'postLoad');
$metadata->addLifecycleCallback('willBeRemoved', 'preRemove');
$metadata->setIdGeneratorType(ClassMetadataInfo::GENERATOR_TYPE_AUTO);
$metadata->setChangeTrackingPolicy(ClassMetadataInfo::CHANGETRACKING_DEFERRED_EXPLICIT);

$builder = new BaseActiveRecord($metadata);

$builder->setMappingDriver(BaseActiveRecord::MAPPING_STATIC_PHP | BaseActiveRecord::MAPPING_ANNOTATION);
$builder->setAnnotationPrefix('orm');

// using custom templates to tweak EntityManager
$builder->addTemplateDir(__DIR__ . '/templates');

// using extensions
$builder->addExtension(new Timestampable());
$builder->addExtension(new GenerationTimestamp());

echo $builder->getCode();