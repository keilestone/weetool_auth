<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2d89818ea8042af9e07ab874e0b3d0e0
{
    public static $prefixLengthsPsr4 = array (
        'w' => 
        array (
            'wtyPls\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'wtyPls\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2d89818ea8042af9e07ab874e0b3d0e0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2d89818ea8042af9e07ab874e0b3d0e0::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
