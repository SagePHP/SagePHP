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

    public function has($key, $section = null) {
        $contents = $this->getContents();
        
        if(null !== $section) {
            if(array_key_exists($section, $contents)) {
                $contents = $contents[$section];
            } else {
                return false;
            }
        }

        return array_key_exists($key, $contents);
    }

    public function get($key) {
        $contents = $this->contents();

        if(array_key_exists($key, $contents)) {
            return $contents[$key];
        }
        
        throw new NotFoundException("Property $key not found");
    }

    public function set($key, $value) {
    }

    private function parseRawContents($rawContents)
    {
        return parse_ini_string($rawContents, $processSections = true);
    }

    private function setContents(Array $contents) 
    {
        $this->contents = $contents;
    }

    private function getContents() 
    {
        if(null === $this->contents) {
            $this->contents = $this->parseRawContents($this->getRawContents());
        }
        return $this->contents;
    }

/*

    private function getFileContents() {
        if (null === $this->contents) {
            $this->contents = parse_ini_string($this->file->load());
        }

        return $this->contents;        
    }

    private function setFileContents(array $contents) {
        $this->contents = $contents;
    }
    }

    public function has($key) {
        $contents = $this->getFileContents();
var_dump($contents);die;
        return array_key_exists($key, $contents);
    }

    public function set($key, $value) {
        $contents = $this->getFileContents();
        $contents[$key] = $value;
        $this->setFileContents($contents);
        $this->save();         
    }

    private function save() {
        $contents = $this->getFileContents();

        // process array to ini format
        $res = array();
        foreach ($contents as $key => $val) {
            if (is_array($val)) {
                $res[] = "[$key]";
                foreach($val as $skey => $sval) {
                    $res[] = "$skey = ".(is_numeric($sval) ? $sval : '"'.$sval.'"');
                }
            } else {
                $res[] = "$key = ".(is_numeric($val) ? $val : '"'.$val.'"');
            }
        }

        $file = $this->file;
        return $file->save(implode("\r\n", $res));
    }
*/
} 
