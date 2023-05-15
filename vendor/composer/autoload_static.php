<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitab56de20d421828f38b1e49b06e83a50
{
    public static $files = array (
        '9b87e216748ad3b26dc95ebf004d8ec9' => __DIR__ . '/../..' . '/src/helpers.php',
    );

    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Symfony\\Component\\Routing\\' => 26,
        ),
        'J' => 
        array (
            'JF\\PHPStrapi\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Symfony\\Component\\Routing\\' => 
        array (
            0 => __DIR__ . '/..' . '/symfony/routing',
        ),
        'JF\\PHPStrapi\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitab56de20d421828f38b1e49b06e83a50::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitab56de20d421828f38b1e49b06e83a50::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitab56de20d421828f38b1e49b06e83a50::$classMap;

        }, null, ClassLoader::class);
    }
}