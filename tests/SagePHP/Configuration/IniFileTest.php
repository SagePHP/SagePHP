<?php

use SagePHP\Configuration\IniFile;

class IniFileTest extends \PHPUnit_Framework_TestCase
{
    private $iniFile;

    function setUp()
    {
        $fileContents = file_get_contents(__DIR__ . "/../../fixtures/basic-ini-file-fixture.ini");

        $this->iniFile = new IniFile($fileContents);
    }


    function test_has_method_with_existing_value_without_section()
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

#   /**
#    * @expectedException NotFoundException
#    */
#  function testGetMethodWithNotExistingValueWithoutSection()
#  {
#      $this->iniFile->get('property-1');        
#  }
}
