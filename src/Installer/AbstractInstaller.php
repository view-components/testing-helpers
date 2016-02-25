<?php
namespace ViewComponents\TestingHelpers\Installer;

use Composer\Script\Event;

abstract class AbstractInstaller
{
    /**
     * @var Event
     */
    protected $event;
    protected $projectDir;
    protected $installerDir;

    public function __construct(Event $event)
    {
        $this->event = $event;
        $this->projectDir = getcwd();
        $this->installerDir = dirname(dirname(__DIR__));
    }

    protected function askYesNo($question, $default = false) {
        $defaultText = '(default = ' . ($default ? 'y':'n') . ')';
        $question = "\t$question [y/n] $defaultText: ";
        $answer = $this->event->getIO()->ask($question);
        if ($answer === '' || $answer === null) {
            return $default;
        }
        return strtolower($answer) === 'y';
    }

    protected function askValue($question, $default = null) {
        $question = "\t$question";
        if ($default) {
            $question.= " (default = $default)";
        }
        $question.=': ';

        $answer = $this->event->getIO()->ask($question);
        if ($answer === null || $answer === '') {
            $answer = $default;
        }
        return trim($answer);
    }

    protected function askValues($requiredValues)
    {
        $answers = [];
        foreach($requiredValues as $name => $default) {
            $answers[$name] = $this->askValue("Enter $name", $default);
        }
        return $answers;
    }

    protected function askChoose($choices, $default = 1) {
        $question = "\tChoose one (default = $default)";
        $id = 0;
        foreach($choices as $choice) {
            $id++;
            $question.= "\r\n\t\t$id) $choice";
        }
        $question.="\r\n\t: ";
        $answer = $this->event->getIO()->ask($question);
        if ($answer === null) {
            $answer = $default;
        }
        $answer = (int)$answer;
        if ($answer > $id || $answer < 1) {
            echo "Wrong answer, enter number from 1 to $id\r\n";
            $this->askChoose($choices);
        }
        return $answer;
    }

    abstract public function run();

    public static function postComposerInstall(Event $event)
    {
        $installer = new static($event);
        $installer->run();
    }
}

