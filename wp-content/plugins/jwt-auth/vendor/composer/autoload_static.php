<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit45cc490e355d7039cd1036dab6308c3e
{
    public static $prefixLengthsPsr4 = array (
        'F' => 
        array (
            'Firebase\\JWT\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Firebase\\JWT\\' => 
        array (
            0 => __DIR__ . '/..' . '/firebase/php-jwt/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit45cc490e355d7039cd1036dab6308c3e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit45cc490e355d7039cd1036dab6308c3e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit45cc490e355d7039cd1036dab6308c3e::$classMap;

        }, null, ClassLoader::class);
    }
}