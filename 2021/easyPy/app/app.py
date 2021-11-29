import re
from flask import Flask, render_template, render_template_string, request

app = Flask(__name__)

def isLegalParam(param):
    return (re.search(r'\'|\"|_|{{.*}}|{%.*%}|\[|\]', param, re.M|re.S) is None)

@app.route('/') 
def main():
    return render_template("index.html")

@app.route('/calc')
def calc():
    formula = request.args.get("calc")
    answer = request.args.get("answer")
    if isLegalParam(formula) and isLegalParam(answer):
        answerHtml = formula + "=" + answer
    else:
        answerHtml = "Data illegality."
    return render_template_string(answerHtml)

@app.route("/hint")
def hint():
    with open(__file__, "rb") as f:
        file = f.read()
    return file

if __name__ == '__main__':
    app.run(host="0.0.0.0")