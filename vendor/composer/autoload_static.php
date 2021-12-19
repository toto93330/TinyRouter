<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit8c47f5e5a6bd71b7d38a612e5ab2785e
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'Anthony\\Router\\' => 15,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Anthony\\Router\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit8c47f5e5a6bd71b7d38a612e5ab2785e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit8c47f5e5a6bd71b7d38a612e5ab2785e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit8c47f5e5a6bd71b7d38a612e5ab2785e::$classMap;

        }, null, ClassLoader::class);
    }
}
