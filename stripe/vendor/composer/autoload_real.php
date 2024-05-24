<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitbf7250387e6e5f6f3706afe2fb3c7e8b
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInitbf7250387e6e5f6f3706afe2fb3c7e8b', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitbf7250387e6e5f6f3706afe2fb3c7e8b', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitbf7250387e6e5f6f3706afe2fb3c7e8b::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}