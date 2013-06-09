<?php

use SagePHP\File\File;
use SagePHP\Coniguration\IniFile;

class IniFileTest extends \PHPUnit_Framework_TestCase
{
    function test_has_method_with_existing_value_without_section()
    {
        $file = $this->getMock('File', array('load', 'save'));
 
        $fileContents = array(
            'section-1' => array(
                'property-1' => 'value-1',
                'property-2' => 'value-2'    
            ),
            'property-3' => 'value-3',
            'property-4' => 'value-4'    
        );

        $file->expects($this->any())
                 ->method('load')
                 ->will($this->returnValue($fileContents));
 
        $iniFile = new IniFile($File);
 
        $this->assertTrue($iniFile->has('property-3'));        
    }


}
