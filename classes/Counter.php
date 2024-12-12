<?php
class CounterResourceException extends Exception {}

class Counter
{
    private $count = 0;
    private $closed = false;

    public function add()
    {
        if ($this->closed) {
            throw new CounterResourceException("Ресурс уже закрыт!");
        }
        $this->count++;
    }

    public function close()
    {
        $this->closed = true;
    }

    public function __destruct()
    {
        if (!$this->closed && $this->count > 0) {
            error_log("Ресурс Counter не был корректно закрыт!");
        }
    }
}
