<?php

namespace SagePHP\Tests\Functional;

include 'bootstrap.php';


$sage->get('console.writer')->writeln(
    '
    <comment>
        LISTS CONTENTS OF A FOLDER (using a system call, so only works on systems that support ls)
    </comment>
    '
);

$path = $sage
    ->get('dialog.prompt')
    ->setQuestion('path to list? ')
    ->show();

$sage
    ->get('exec')
    ->setCommand("ls -ls $path")
    ->run();
