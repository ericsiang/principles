<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit1792ddfaa498b1c54571b6ae18c981f9
{
    public static $classMap = array (
        'Illuminate\\Container\\Container' => __DIR__ . '/../..' . '/Package/laravel/framework/src/Illuminate/Container/Container.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit1792ddfaa498b1c54571b6ae18c981f9::$classMap;

        }, null, ClassLoader::class);
    }
}