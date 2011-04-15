<?php

require_once __DIR__.'/vendor/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Propel\\Tests'    => __DIR__.'/tests',
    'Propel'           => __DIR__.'/src',
    'Doctrine\\Common' => __DIR__.'/vendor/doctrine-common/lib',
    'Doctrine\\DBAL'   => __DIR__.'/vendor/doctrine-dbal/lib',
    'Doctrine\\ORM'    => __DIR__.'/vendor/doctrine/lib',
    'Model'            => __DIR__,
));
$loader->registerPrefixes(array(
    'Twig_'            => __DIR__.'/vendor/twig/lib',
));
$loader->register();
