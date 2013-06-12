<?php
namespace SagePHP\VCS;

use SagePHP\System\Exec;
use SagePHP\System\Command;

/**
 * abstraction class arrounf git dvcs
 */
class Git
{
    /**
     * helper process execution system
     * @var Process
     */
    private $exec = null;

    public function __construct(Exec $exec)
    {
         $this->exec = $exec;
    }

    private function execute(Command $command)
    {
        $exec = $this->exec;
        $exec->setCommand($command);

        $code = $exec->run();
        $output = $exec->getOutput();

        if ($exec->hasErrors()) {

            switch ($code) {
                case 127:
                    $msg = 'git command not found, make sure it is installed an in the system path';
                    break;
                default:
                    $msg = 'Git execution failed : ' .$code . ' ' . $output['stderror'];
                    break;
            }

            throw new \RuntimeException($msg, $code);
        }

        return $code;
    }

    public function cloneRepository($uri, $folder = null, $branch = null)
    {
        $command = new Command;
        $command
            ->binary('git')
            ->argument('clone')
            ->argument($uri);

        if (null !== $folder) {
            $command->argument($folder);
        }

        if (null !== $branch) {
            $command->option('branch', $branch);
        }

        $this->execute($command);
        
    }
}
