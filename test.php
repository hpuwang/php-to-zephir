<?php

ini_set('xdebug.max_nesting_level', 2000);

$vendorDir = __DIR__ . '/vendor';

if (false === is_file($vendorDir . '/autoload.php')) {
    throw new \Exception("You must set up the project dependencies, run the following commands:
                    wget http://getcomposer.org/composer.phar
                    php composer.phar install
                    ");
} else {
    include($vendorDir . '/autoload.php');
}

use PhpToZephir\EngineFactory;

$classLoader = new \Composer\Autoload\ClassLoader();

try {
    $engine = EngineFactory::getInstance();

    $dirPath = __DIR__ . '/vendor/symfony/event-dispatcher/Symfony/Component/EventDispatcher/';

    foreach ($engine->convertDirectory($dirPath) as $convertedCode) {
        echo 'Converted ' . $convertedCode['path'] . '/' . $convertedCode['fileName'] . "\n";

        @mkdir('converted/' . $convertedCode['path'], 0777, true);
        file_put_contents('converted/' . $convertedCode['path'] . $convertedCode['fileName'] . '.zep', $convertedCode['zephir']);
    }

    /*
    $classToConvert = array(
        'Event'
    );

    foreach ($classToConvert as $name) {
        echo 'Convert ' . $name . "\n";
        $rst = $engine->convertClass('Symfony\Component\EventDispatcher\\' . $name);

        file_put_contents('Symfony/Component/EventDispatcher/' . $name . '.zep', $rst);
    }
*/

    // $stmts is an array of statement nodes
} catch (PhpParser\Error $e) {
    echo 'Parse Error: ', $e->getMessage();
}