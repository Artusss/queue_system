<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitdcca0a23b363727f719e314a45919356
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Src\\' => 4,
        ),
        'Q' => 
        array (
            'Queue\\' => 6,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Src\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
        'Queue\\' => 
        array (
            0 => __DIR__ . '/../..' . '/queue',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitdcca0a23b363727f719e314a45919356::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitdcca0a23b363727f719e314a45919356::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
