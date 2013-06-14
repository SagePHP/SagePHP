<?php

namespace SagePHP\System\Dialog;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Helper\DialogHelper;

/**
 * Wrapper class around symfony console dialog helper.
 */
abstract class AbstractDialog implements DialogInterface
{
    /**
     * helper class to write to sdtout and stderr
     * @var OutputInterface
     */
    private $output = null;

    /**
     * helper class to show interaction dialogs to the user
     * @var DialogHelper
     */
    private $dialogHelper = null;

    public function __construct(OutputInterface $output, DialogHelper $dialogHelper)
    {
        $this->setOutput($output);
        $this->setDialogHelper($dialogHelper);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function show();

    /**
     * Gets the helper class to write to sdtout and stderr.
     *
     * @return OutputInterface
     */
    protected function getOutput()
    {
        return $this->output;
    }

    /**
     * Sets the helper class to write to sdtout and stderr.
     *
     * @param OutputInterface $output the output
     *
     * @return self
     */
    private function setOutput(OutputInterface $output)
    {
        $this->output = $output;

        return $this;
    }

    /**
     * Gets the helper class to show interaction dialogs to the user.
     *
     * @return DialogHelper
     */
    protected function getDialogHelper()
    {
        return $this->dialogHelper;
    }

    /**
     * Sets the helper class to show interaction dialogs to the user.
     *
     * @param DialogHelper $dialogHelper the dialogHelper
     *
     * @return self
     */
    private function setDialogHelper(DialogHelper $dialogHelper)
    {
        $this->dialogHelper = $dialogHelper;

        return $this;
    }
}
