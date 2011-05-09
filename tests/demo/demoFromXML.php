#!/usr/bin/php
<?php

$inputDirectory  = __DIR__ . '/schema';
$fileExtension   = '.dcm.xml';
$outputDirectory = __DIR__ . '/Model';

require_once __DIR__ . '/../../autoload.php';

use Propel\Builder\ORM\BaseActiveRecord;
use Propel\Builder\ORM\ActiveRecord;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Propel\Builder\Generator;

$driverImpl = new XmlDriver($inputDirectory);
$driverImpl->setFileExtension($fileExtension);

$config = new Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$config->setMetadataDriverImpl($driverImpl);
$config->setProxyDir(__DIR__ . '/Proxies');
$config->setProxyNamespace('Proxies');

$cmf = new DisconnectedClassMetadataFactory();
$cmf->setEntityManager(\Doctrine\ORM\EntityManager::create(array(
    'driver' => 'pdo_sqlite',
    'path'   => 'database.sqlite'
), $config));

$generator = new Generator();

foreach ($cmf->getAllMetadata() as $metadata) {
    /* @var $metadata Doctrine\ORM\Mapping\ClassMetadataInfo */

    $builder = new BaseActiveRecord($metadata);
    $builder->setMappingDriver(BaseActiveRecord::MAPPING_STATIC_PHP | BaseActiveRecord::MAPPING_ANNOTATION);
    $builder->setAnnotationPrefix('orm');

    $generator->addBuilder($builder);
    $generator->addBuilder(new ActiveRecord($metadata));
}

echo "Generating classes for xml schemas...\n";
$generator->writeClasses($outputDirectory);
echo "Class generation complete\n";
