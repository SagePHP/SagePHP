<?php

namespace SagePHP\Test;

use SagePHP\Configuration\IniFile;
use SagePHP\Exception\NotFoundException;

class IniFileTest extends \PHPUnit_Framework_TestCase
{
    private $iniFile;

    protected function setUp()
    {
        $this->fileContents = file_get_contents(__DIR__ . "/../../fixtures/basic-ini-file-fixture.ini");

        $this->iniFile = new IniFile($this->fileContents);
    }


    public function testHasMethodWithExistingValueWithoutSection()
    {
        $this->assertTrue($this->iniFile->has('property-3'));
    }

    public function testHasMethodWithNotExistingValueWithoutSection()
    {
        $this->assertFalse($this->iniFile->has('not-existing-property'));
    }

    public function testHasMethodWithSectionWithExistingValue()
    {
        $this->assertTrue($this->iniFile->has('property-1', 'section-1'));
    }

    public function testHasMethodWithSectionWithNotExistingValue()
    {
        $this->assertFalse($this->iniFile->has('property-3', 'section-1'));
    }

    public function testGetMethodWithExistingValueWithoutSection()
    {
        $this->assertEquals('value-3', $this->iniFile->get('property-3'));
    }

    public function testGetMethodWithExistingValueWithSection()
    {
        $this->assertEquals('value-1', $this->iniFile->get('property-1', 'section-1'));
    }

    /**
     * @expectedException SagePHP\Exception\NotFoundException
     */
    public function testGetMethodWithNotExistingValueWithoutSection()
    {
        $this->iniFile->get('property-1');
    }

    public function testSetMethodWithoutSection()
    {
        $this->iniFile->set('new-property', 'new value');
        $this->assertEquals('new value', $this->iniFile->get('new-property'));
    }

    public function testSetMethodWithExistingSection()
    {
        $this->iniFile->set('new-property', 'new value', 'section-1');
        $this->assertEquals('new value', $this->iniFile->get('new-property', 'section-1'));
    }

    public function testSetMethodWithNewSection()
    {
        $this->iniFile->set('new-property', 'new value', 'new-section');
        $this->assertEquals('new value', $this->iniFile->get('new-property', 'new-section'));
    }

    public function testToString()
    {
        $this->assertEquals($this->fileContents, (string) $this->iniFile);
    }
}
