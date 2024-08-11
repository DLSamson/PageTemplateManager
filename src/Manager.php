<?php

namespace PageTemplateManager;
use PageTemplateManager\Traits\Singleton;

class Manager
{
    use Singleton;

    public function __construct($config) {

        if (is_string($config))
            $this->config = require $config;
        else if (is_array($config))
            $this->config = $config;
        else
            throw new \InvalidArgumentException(sprintf('$config parameter must be type of array or string. Found: %s', gettype($config)));
    }

    protected array $config;

    
}