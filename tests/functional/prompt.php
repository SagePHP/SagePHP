<?php

namespace SagePHP\Tests\Functional;

include 'bootstrap.php';

$prompt = $sage->get('dialog.prompt');

$prompt->setQuestion('your name? ');

$value = $prompt->show();

echo "welcome $value\n";
