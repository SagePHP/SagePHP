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


    function testHas_method_with_existing_value_without_section()
    {
        $this->assertTrue($this->iniFile->has('property-3'));        
    }

    function test_has_method_with_not_existing_value_without_section()
    {
        $this->assertFalse($this->iniFile->has('not-existing-property'));        
    }

    function test_has_method_with_section_with_existing_value()
    {
        $this->assertTrue($this->iniFile->has('property-1', 'section-1'));        
    }

    function testHasMethodWithSectionWithNotExistingValue()
    {
        $this->assertFalse($this->iniFile->has('property-3', 'section-1'));        
    }

    function testGetMethodWithExistingValueWithoutSection()
    {
        $this->assertEquals('value-3', $this->iniFile->get('property-3'));        
    }

    function testGetMethodWithExistingValueWithSection()
    {
        $this->assertEquals('value-1', $this->iniFile->get('property-1', 'section-1'));        
    }

    /**
     * @expectedException SagePHP\Exception\NotFoundException
     */
    function testGetMethodWithNotExistingValueWithoutSection()
    {
        $this->iniFile->get('property-1');        
    }

    function testSetMethodWithoutSection()
    {
        $this->iniFile->set('new-property', 'new value');
        $this->assertEquals('new value', $this->iniFile->get('new-property')); 
    }

    function testSetMethodWithExistingSection()
    {
        $this->iniFile->set('new-property', 'new value', 'section-1');
        $this->assertEquals('new value', $this->iniFile->get('new-property', 'section-1')); 
    }
    
    function testSetMethodWithNewSection()
    {
        $this->iniFile->set('new-property', 'new value', 'new-section');
        $this->assertEquals('new value', $this->iniFile->get('new-property', 'new-section')); 
    }

    function testToString()
    {
        $this->assertEquals($this->fileContents, (string) $this->iniFile);
    }

}

