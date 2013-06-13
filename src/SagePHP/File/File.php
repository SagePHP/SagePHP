<?php

namespace SagePHP\File;

class File extends \SPLFileInfo implements FileInterface
{
    public function load()
    {
        return file_get_contents($this);
    }

    public function save($data)
    {
        return file_put_contents($this, $data);
    }
}
