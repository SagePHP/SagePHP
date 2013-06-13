<?php

namespace SagePHP\Configuration;

use SagePHP\Exception\NotFoundException;

class IniFile implements ConfigurationFileInterface
{
    private $rawContents = null;
    private $contents = null;

    public function __construct($rawContents)
    {
        $this->setRawContents($rawContents);
    }

    private function setRawContents($rawContents)
    {
        if (false === is_string($rawContents)) {
            throw new \InvalidArgumentException("Raw contents needs to be a string", 400);
        }
        $this->rawContents = $rawContents;
    }

    private function getRawContents()
    {
        return $this->rawContents;
    }

    public function has($key, $section = null)
    {
        try {
            $contents = $this->getContents($section);
            return array_key_exists($key, $contents);
        } catch (\Exception $e) {
            return false;
        }
    }

    public function get($key, $section = null)
    {
        $contents = $this->getContents($section);

        if (array_key_exists($key, $contents)) {
            return $contents[$key];
        }
        
        throw new NotFoundException("Property $key not found");
    }

    public function set($key, $value, $section = null)
    {
        $contents = $this->getContents();
        if (null !== $section) {
            $contents[$section][$key] = $value;
        }
        $contents[$key] = $value;
        $this->setContents($contents);
    }

    private function parseRawContents($rawContents)
    {
        return parse_ini_string($rawContents, $processSections = true);
    }

    private function setContents(Array $contents)
    {
        $this->contents = $contents;
    }

    private function getContents($section = null)
    {
        if (null === $this->contents) {
            $this->contents = $this->parseRawContents($this->getRawContents());
        }

        if (null !== $section) {
            if (array_key_exists($section, $this->contents)) {
                return $this->contents[$section];
            } else {
                throw new NotFoundException("Section $section not found");
            }
        }

        return $this->contents;
    }

    public function __toString()
    {
        $contents = $this->getContents();

        $ret = '';
        foreach ($contents as $key => $value) {
            if (false === is_array($value)) {
                $ret .= sprintf("%s = \"%s\"\n", $key, $value);
            }
        }

        foreach ($contents as $key => $value) {
            if (true === is_array($value)) {
                $ret .= sprintf("\n[%s]\n", $key);
                foreach ($value as $innerSectionKey => $innerSectionValue) {
                    $ret .= sprintf("    %s = \"%s\"\n", $innerSectionKey, $innerSectionValue);
                }
            }
        }

        return $ret;
    }
}
