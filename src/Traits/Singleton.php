<?php

namespace PageTemplateManager\Traits;

use PageTemplateManager\Exceptions\SingletonPatternIsNotSet;
use ReflectionClass;

trait Singleton {
    protected static $instance;
    protected static $isSingletonPatter = false;

    public static function enableSingletonPattern(...$constructorArgs) {
        self::$isSingletonPatter = true;

        $reflect  = new ReflectionClass(static::class);
        self::$instance = $reflect->newInstanceArgs($constructorArgs);
    }

    public static function disableSingletonPattern() {
        self::$isSingletonPatter = false;
        self::$instance = null;
    }

    public static function __callStatic($method, $args)
    {
        if (!self::$isSingletonPatter)
            throw new SingletonPatternIsNotSet(sprintf('Enable singelton patter via %s::enableSingletonPattern() method', static::class));

        call_user_func([self::$instance, $method], ...$args);
    }
}