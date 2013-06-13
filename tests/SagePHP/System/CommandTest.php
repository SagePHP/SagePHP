<?php

namespace SagePHP\Test;

use SagePHP\System\Command;

class Commandtest extends \PHPUnit_Framework_TestCase
{
    public function testBinary()
    {
        $command = new Command;

        $command->binary('foo');

        $this->assertEquals('foo', (string) $command);
    }

    public function testArgument()
    {
        $command = new Command;

        $command->argument('foo');

        $this->assertEquals('foo', (string) $command);
    }

    public function testShortOptionNoValue()
    {
        $command = new Command;

        $command->option('o');

        $this->assertEquals('-o', (string) $command);
    }

    public function testShortOptionWithValue()
    {
        $command = new Command;

        $command->option('o', 'bar');

        $this->assertEquals('-o bar', (string) $command);
    }

    public function testLongtOptionNoValue()
    {
        $command = new Command;

        $command->option('long');

        $this->assertEquals('--long', (string) $command);
    }

    public function testLongOptionWithValue()
    {
        $command = new Command;

        $command->option('long', 'bar');

        $this->assertEquals('--long bar', (string) $command);
    }

    public function testFile()
    {
         $command = new Command;

        $command->file('file');

        $this->assertEquals('"file"', (string) $command);
    }

    public function testComplexCommand()
    {
        $command = new Command;

        $command->binary('binary')
            ->argument('argument1')
            ->argument('argument2')
            ->option('n', 'n')
            ->option('long', 'option')
            ->file('file');

        $expected = 'binary argument1 argument2 -n n --long option "file"';

        $this->assertEquals($expected, (string) $command);
    }
}
