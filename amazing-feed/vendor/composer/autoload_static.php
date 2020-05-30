<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2575c29644b83322c4773361dc1e8e6a
{
    public static $prefixLengthsPsr4 = array (
        'A' => 
        array (
            'AF\\' => 3,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'AF\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2575c29644b83322c4773361dc1e8e6a::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2575c29644b83322c4773361dc1e8e6a::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
