<?php

namespace SagePHP\Tests;

use SagePHP\System\Dialog\PromptDialog;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Console\Helper\DialogHelper;

class PromptDialogTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->output = $this->getMock('Symfony\Component\Console\Output\ConsoleOutput');
        $this->dialogHelper = $this->getMock('Symfony\Component\Console\Helper\DialogHelper');

    }

    public function testGettersAndSetters()
    {
        $promptDialog = new PromptDialog($this->output, $this->dialogHelper);

        $this->assertNull($promptDialog->getQuestion());
        $this->assertNull($promptDialog->getDefault());

        $promptDialog->setQuestion('foo');
        $this->assertEquals('foo ', $promptDialog->getQuestion());

        $promptDialog->setDefault('default');
        $this->assertEquals('default', $promptDialog->getDefault());
    }

    public function testPromptDialog()
    {

            $this->dialogHelper
                ->expects($this->once())
                ->method('ask')
                ->will($this->returnValue('foo'));

            $promptDialog = new PromptDialog($this->output, $this->dialogHelper);

            $result = $promptDialog->setQuestion('test')->show();

            $this->assertEquals('foo', $result);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Question cannot be null
     */
    public function testPromptDialogWithNoQuestion()
    {

            $promptDialog = new PromptDialog($this->output, $this->dialogHelper);

            $result = $promptDialog->show();

            $this->assertEquals('foo', $result);
    }
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Question should be a string
     */
    public function testPromptDialogWithQuestionOfInvalidType()
    {

            $promptDialog = new PromptDialog($this->output, $this->dialogHelper);

            $result = $promptDialog->setQuestion(123)->show();

            $this->assertEquals('foo', $result);
    }
}
