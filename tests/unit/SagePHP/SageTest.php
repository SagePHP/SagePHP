<?php

namespace SagePHP\Test;

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

    /**
     * @expectedException Symfony\Component\DependencyInjection\Exception\InvalidArgumentException
     */
    public function testGetNotFoundAlias()
    {
        $sage = new Sage;
        $git = $sage->get('Git12345678909876543');
    }
}
