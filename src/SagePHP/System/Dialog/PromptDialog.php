<?php

namespace SagePHP\System\Dialog;

/**
 * Asks the user for input
 */
class PromptDialog extends AbstractDialog
{
    private $question = null;
    private $default = null;

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function show()
    {
        $question = $this->getQuestion();

        if (empty($question)) {
            throw new \InvalidArgumentException('Question cannot be null');
        }

        $dialogHelper = $this->getDialogHelper();
        $outputHelper = $this->getOutput();

        return $dialogHelper->ask($outputHelper, $question, $this->getDefault(), $autocomplete = null);
    }
    /**
     * Gets the value of question.
     *
     * @return mixed
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * Sets the value of question.
     *
     * @param string $question the question
     *
     * @return self
     */
    public function setQuestion($question)
    {
        if (false === is_string($question)) {
            throw new \InvalidArgumentException('Question should be a string');
        }

        $this->question = trim($question) . " " ;

        return $this;
    }

    /**
     * Gets the value of default.
     *
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Sets the value of default.
     *
     * @param mixed $default the default
     *
     * @return self
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }
}
