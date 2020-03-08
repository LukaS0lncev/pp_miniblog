<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit20f151f23a2d5f5f5451fb2fe678c9e6
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PpMiniblog\\Controller\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PpMiniblog\\Controller\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src/Controller',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit20f151f23a2d5f5f5451fb2fe678c9e6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit20f151f23a2d5f5f5451fb2fe678c9e6::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}