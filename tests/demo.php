<?php

require_once __DIR__ . '/bootstrap.php';

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