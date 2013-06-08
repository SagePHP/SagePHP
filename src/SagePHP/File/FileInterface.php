<?php

namespace SagePHP\File;

interface FileInterface
{
    public function load();

    public function save($data);
}
