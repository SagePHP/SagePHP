<?php

use SagePHP\Configuration\IniFile;

class IniFileTest extends \PHPUnit_Framework_TestCase
{
    function test_has_method_with_existing_value_without_section()
    {
        $fileContents = file_get_contents(__DIR__ . "/../../fixtures/basic-ini-file-fixture.ini");

        $iniFile = new IniFile($fileContents);
 
        $this->assertTrue($iniFile->has('property-3'));        
    }


}
