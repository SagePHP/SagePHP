<?php

namespace SagePHP\System;

/**
 * helper class for building CLI commands
 */
class Command
{
    private $parts = array();

    public function add($item, $quoted = false, $offset = null)
    {
        if (true === $quoted) {
            $item = '"' . $item . '"';
        }

        $this->parts[] = $item;
    }
    
    public function binary($path)
    {
        $this->add($path);

        return $this;
    }

    public function argument($name)
    {
        $this->add($name);

        return $this;
    }

    public function option($name, $value = null)
    {
        $value = null === $value ? '': $value;

        $prefix = strlen($name) == 1 ? '-' : '--';
        $this->add($prefix . $name);

        if (null !== $value) {
            $this->add($value);
        }

        return $this;
    }

    public function file($name)
    {
        $this->add($name, $quoted = true);

        return $this;
    }

    public function __toString()
    {
        return trim(implode(' ', $this->parts));
    }
}
