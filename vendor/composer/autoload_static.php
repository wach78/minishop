<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitaecc88f56a21a3f536c5737ea354a200
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'Simpleframework\\' => 16,
        ),
        'D' => 
        array (
            'Dotenv\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Simpleframework\\' => 
        array (
            0 => __DIR__ . '/../..' . '/App',
        ),
        'Dotenv\\' => 
        array (
            0 => __DIR__ . '/..' . '/vlucas/phpdotenv/src',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitaecc88f56a21a3f536c5737ea354a200::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitaecc88f56a21a3f536c5737ea354a200::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
