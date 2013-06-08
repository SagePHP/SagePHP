<?php

namespace SagePHP\Coniguration;

use SagePHP\File\File;

class IniFile implements ConfigurationFileInterface
{
    private $file;
    private $contents = [];

    public function __construct(File $file) {
       $this->file = $file; 
    }

    private function getFileContents() {
        if (null === $this->contents) {
            $this->contents = parse_ini_file($this->file->load());
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
    }

} 
