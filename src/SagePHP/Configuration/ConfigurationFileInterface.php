<?php

namespace SagePHP\Configuration;

interface ConfigurationFileInterface
{
    public function get($key);

    public function set($key, $value);
    
    public function has($key, $section = null);
}
