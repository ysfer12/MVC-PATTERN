<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInitd69f16c3580a5efab6b7c9fabc0cdc37
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

        spl_autoload_register(array('ComposerAutoloaderInitd69f16c3580a5efab6b7c9fabc0cdc37', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInitd69f16c3580a5efab6b7c9fabc0cdc37', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInitd69f16c3580a5efab6b7c9fabc0cdc37::getInitializer($loader));

        $loader->register(true);

        return $loader;
    }
}
