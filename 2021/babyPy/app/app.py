from flask import Flask, render_template_string, request

app = Flask(__name__)

@app.route('/') 
def main():
    html = """
<html>
    <head>
        <title>HTML test</title>
    </head>
    <body>
        <h2>Let's try HTML</h2>
        <hr>
        <form action="/try" id="try" method="POST">
            Title: <input type="text" name="title">
            <input type="submit"><br>
            <textarea rows="4" cols="50" name="body" form="try"><body></body></textarea>
        </form>
    </body>
</html>
    """
    return render_template_string(html)

@app.route('/try', methods=["POST"])
def try_html():
    title = request.form.get("title")
    body = request.form.get("body")
    html = f"""
<html>
    <title>{title}</title>
    {body}
</html>
    """
    return render_template_string(html)

if __name__ == '__main__':
    app.run(host="0.0.0.0")