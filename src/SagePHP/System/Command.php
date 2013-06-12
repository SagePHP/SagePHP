<?php

namespace SagePHP\System;

/**
 * helper class for building CLI commands
 */
class Command
{
    private $parts = array();

    /**
     * adds a CLI part.
     * This function exposes the full functionality to end users
     * 
     * @param mixed  $item   the item to add to the CLI
     * @param boolean $quoted should $item be encloded in double quotes?
     */
    public function add($item, $quoted = false)
    {
        if (true === $quoted) {
            $item = '"' . $item . '"';
        }

        $this->parts[] = $item;
    }
    
    /**
     * adds a binary
     * 
     * @param  string $path 
     *             
     * @return self
     */
    public function binary($path)
    {
        $this->add($path);

        return $this;
    }


    /**
     * adds a positional argument.
     * 
     * @param  string $name 
     * 
     * @return self       
     */
    public function argument($name)
    {
        $this->add($name);

        return $this;
    }

    /**
     * adds an option.
     * if the option is only 1 char then it will considered a short option and prefixed with -, otherwise with --
     * 
     * @param  string $name 
     * @param  string $value 
     * 
     * @return self        
     */
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

    /**
     * Adds a quoted path
     * 
     * @param  string $name 
     * 
     * @return self       
     */
    public function file($name)
    {
        $this->add($name, $quoted = true);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return trim(implode(' ', $this->parts));
    }
}
