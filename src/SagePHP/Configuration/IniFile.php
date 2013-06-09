<?php

namespace SagePHP\Configuration;

use SagePHP\Exception\NotFoundException;
use SagePHP\File\FileInterface;

class IniFile implements ConfigurationFileInterface
{
    private $file;
    private $contents = null;

    public function __construct(FileInterface $file) {
       $this->file = $file; 
    }

    private function getFileContents() {
        if (null === $this->contents) {
            $this->contents = parse_ini_string($this->file->load());
        }

        return $this->contents;        
    }

    private function setFileContents(array $contents) {
        $this->contents = $contents;
    }

    public function get($key) {
        $contents = $this->getFileContents();

        if(array_key_exists($key, $contents)) {
            return $contents[$key];
        }
        
        throw new NotFoundException("Property $key not found");
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

} 
