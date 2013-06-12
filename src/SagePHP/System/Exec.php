<?php 

namespace SagePHP\System;

use Symfony\Component\Process\Process;

/**
 * Executes system commands
 *
 * @todo implement a logger
 * @todo does it make sense to pass Symfony Process as dependency ?
 */
class Exec
{

    /**
     * the command to execute
     * @var string
     */
    private $command;

    /**
     * Helper class to execute commands
     * @var Process
     */
    private $process;

    /**
     * executes a system command
     * 
     * @param string $command
     */
    public function __construct($command = null)
    {
        $this->setCommand($command);
    }

    /**
     * gets the helper class to execute a command.
     * 
     * @return Process
     */
    private function getProcessExecutor()
    {
        if (null === $this->process) {
            $this->process = new Process('');
        }

        return $this->process;
    }

    /**
     * Gets the the command to execute.
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Sets the the command to execute.
     *
     * @param string $command the command
     *
     * @return self
     */
    public function setCommand($command)
    {
        $this->command = $command;

        return $this;
    }



    /**
     * executes the command.
     * 
     * @return integer the return code of the executed command
     */
    public function run()
    {
        $process = $this->getProcessExecutor();
        $process->setCommandLine($this->getCommand());

        $logger = function ($error, $line) {
            call_user_func_array(array($this, 'logLine'), array($error, $line));
        };

        return $process->run($logger);
    }


    public function hasErrors()
    {
        $process = $this->getProcessExecutor();

        return false === $process->isSuccessful();
    }

    /**
     * gets the command output
     * 
     * @return array
     */
    public function getOutput()
    {
        $process = $this->getProcessExecutor();

        return array(
            'stdout' => $process->getOutput(),
            'stderror' => $process->getErrorOutput(),
        );
    }

    /**
     * logs a line from the command output
     * @return [type]
     */
    protected function logLine($messageType, $messageText)
    {
        switch ($messageType) {
            case Process::ERR:
                $typeStr = "[Error]";
                break;
            default:
                $typeStr = "";
                break;
        }
        
        echo sprintf("\n%s %s\n", $typeStr, $messageText);
    }

    public function getExitCode()
    {
        return $this->getProcessExecutor()->getExitCode();
    }
}
