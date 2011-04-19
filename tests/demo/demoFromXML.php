<?php

require_once __DIR__ . '/../../autoload.php';

use Propel\Builder\ORM\BaseActiveRecord;
use Propel\Builder\ORM\ActiveRecord;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use Doctrine\ORM\Tools\DisconnectedClassMetadataFactory;
use Propel\Builder\Generator;

$config = new Configuration();
$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\ArrayCache);
$driverImpl = new XmlDriver(__DIR__ . '/schema');
$config->setMetadataDriverImpl($driverImpl);

$config->setProxyDir(__DIR__ . '/Proxies');
$config->setProxyNamespace('Proxies');

$connectionOptions = array(
    'driver' => 'pdo_sqlite',
    'path' => 'database.sqlite'
);

$em = \Doctrine\ORM\EntityManager::create($connectionOptions, $config);
$cmf = new DisconnectedClassMetadataFactory();
$cmf->setEntityManager($em);

$generator = new Generator();
foreach ($cmf->getAllMetadata() as $metadata) {
    $generator->addBuilder(new BaseActiveRecord($metadata));
    $generator->addBuilder(new ActiveRecord($metadata));
}
echo "Generating classes for xml schemas...\n";
$generator->writeClasses(__DIR__ . '/Model');
echo "Class generation complete\n";
