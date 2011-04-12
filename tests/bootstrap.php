<?php

include __DIR__ . '/../config.php';

// autoloader
require($config['classloader_dir'].'/UniversalClassLoader.php');

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Propel\\Tests'    => __DIR__,
    'Propel'           => __DIR__.'/../src',
    'Doctrine\\Common' => $config['doctrine_common_lib_dir'],
    'Doctrine\\DBAL'   => $config['doctrine_dbal_lib_dir'],
    'Doctrine\\ORM'    => $config['doctrine_orm_lib_dir'],
    'Model'            => __DIR__,
));
$loader->registerPrefixes(array(
    'Twig_'            => $config['twig_lib_dir'],
));
$loader->register();