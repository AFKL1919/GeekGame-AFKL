<?php
class a {
    public function __destruct()
    {
        $this->test->test();
    }
}

abstract class b {
    private $b = 1;

    abstract protected function eval();

    public function test() {
        ($this->b)();
    }
}

class c extends b {
    private $call;
    protected $value;

    protected function eval() {
        if (is_array($this->value)) {
            ($this->call)($this->value);
        } else {
            die("you can't do this :(");
        }
    }
}

class d {
    public $value;

    public function eval($call) {
        $call($this->value);
    }
}

if (isset($_GET['data'])) {
    unserialize(base64_decode($_GET['data']));
} else {
    highlight_file(__FILE__);
}