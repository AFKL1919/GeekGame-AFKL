<?php
class a {
    public static $Do_u_like_JiaRan = false;
    public static $Do_u_like_AFKL = false;
}

class b {
    private $i_want_2_listen_2_MaoZhongDu;
    public function __toString()
    {
        if (a::$Do_u_like_AFKL) {
            return exec($this->i_want_2_listen_2_MaoZhongDu);
        } else {
            throw new Error("Noooooooooooooooooooooooooooo!!!!!!!!!!!!!!!!");
        }
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

if (isset($_GET['data'])) {
    unserialize(base64_decode($_GET['data']));
} else {
    highlight_file(__FILE__);
}