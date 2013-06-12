<?php

use SagePHP\VCS\Git;
use SagePHP\Sage;

class SageTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $sage = new Sage;
        $git = $sage->get('Git');

        $this->assertInstanceOf('SagePHP\VCS\Git', $git);
    }
}
