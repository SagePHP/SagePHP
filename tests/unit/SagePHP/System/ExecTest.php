<?php

namespace SagePHP\Test;

use SagePHP\System\Exec;

class Exectest extends \PHPUnit_Framework_TestCase
{
    public function testExec()
    {
        $exec = new Exec('ls -ls');
        $code = $exec->run();

        $this->assertEquals(0, $exec->getExitCode());

        $output = $exec->getOutput();

        $this->assertTrue(is_array($output), 'exec output should be an array');
        $this->assertCount(2, $output, 'exec output should have 2 keys');
        $this->assertArrayHasKey('stdout', $output, 'exec output should have stdout');
        $this->assertArrayHasKey('stderror', $output, 'exec output should have stderror');
        $this->assertEmpty($output['stderror'], 'exec output should stderror should be empty');
        $this->assertNotEmpty($output['stdout'], 'exec output should stdout should have some data');
        $this->assertFalse($exec->hasErrors(), 'exec should have completed without errors');
    }

    public function testExecWithError()
    {
        $exec = new Exec('lszxczxzxc -ls');
        $code = $exec->run();

        $this->assertEquals(127, $exec->getExitCode());

        $output = $exec->getOutput();

        $this->assertTrue(is_array($output), 'exec output should be an array');
        $this->assertCount(2, $output, 'exec output should have 2 keys');
        $this->assertArrayHasKey('stdout', $output, 'exec output should have stdout');
        $this->assertArrayHasKey('stderror', $output, 'exec output should have stderror');
        $this->assertNotEmpty($output['stderror'], 'exec output should stderror should not be empty');
        $this->assertEmpty($output['stdout'], 'exec output should stdout should be empty');
        $this->assertTrue($exec->hasErrors(), 'exec should have completed with errors');
    }
}
