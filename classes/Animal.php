<?php
abstract class Animal
{
    protected $name;
    protected $birthDate;
    protected $commands = [];

    public function __construct($name, $birthDate)
    {
        $this->name = $name;
        $this->birthDate = $birthDate;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getBirthDate()
    {
        return $this->birthDate;
    }

    public function getCommands()
    {
        return $this->commands;
    }

    public function addCommand($command)
    {
        $this->commands[] = $command;
    }
}
