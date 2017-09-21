<?php

require __DIR__.'/../../vendor/autoload.php';

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;


$config = \Framework\App::loadConfig(true);
 $dbParams = array(
                'driver'   => 'pdo_mysql',
                'user'     => $config["doctrine"]["user"],
                'password' => $config["doctrine"]["password"],
                'dbname'   => $config["doctrine"]["dbname"],
                'charset' => 'utf8',
                
            );
            $cachedir = __DIR__."/cache";
            $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../../src/Entity"), false, $cachedir);
            $doctrine = EntityManager::create($dbParams, $config);



return ConsoleRunner::createHelperSet($doctrine);