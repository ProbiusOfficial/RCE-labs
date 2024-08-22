from flask import Flask, request, render_template_string, send_from_directory
import re
import subprocess

app = Flask(__name__)

@app.route('/', methods=['GET', 'POST'])
def terminal():
    output = '''
    
    # -*- coding: utf-8 -*-
    # @Author: 探姬
    # @Date:   2024-08-11 14:34
    # @Repo:   github.com/ProbiusOfficial/RCE-labs
    # @email:  admin@hello-ctf.com
    # @link:   hello-ctf.com
    
    --- HelloCTF - RCE靶场 : 命令执行 - bash终端的无字母命令执行_0的特殊变量替换  --- 

    题目已经拥有成熟脚本：https://github.com/ProbiusOfficial/bashFuck
    你也可以使用在线生成：https://probiusofficial.github.io/bashFuck/
    题目本身也提供一个/exp 方便你使用
    "WAF:[A-Za-z0-9\"%*+,-.\/:;=>?@[\]^`|&_~]"
    由于转义以及PHP中system函数的缺陷（指无法像 subprocess 那样提供一个完全一致的 Bash 环境？），这里使用Flask环境下的subprocess模块来执行命令。
    当然这也暴露出该方法的局限性。
    '''
    if request.method == 'POST':
        command = request.form['command']
        if re.search(r'[A-Za-z0-9\"%*+,-.\/:;=>?@[\]^`|&_~]', command):
           output = "Command blocked by WAF!"
        else:
            try:
                # 使用 Bash 来执行命令
                output = subprocess.check_output(['bash', '-c', command], stderr=subprocess.STDOUT, text=True)
            except subprocess.CalledProcessError as e:
                output = e.output
        
        return render_template_string(TEMPLATE, command=command, output=output)
    
    return render_template_string(TEMPLATE, command="", output=output)

TEMPLATE = """
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Virtual Terminal</title>
    <style>
      body {
        background-color: #f8f9fa;
        font-family: Arial, sans-serif;
      }
      .terminal-container {
        max-width: 800px;
        margin: 50px auto;
        padding: 30px;
        background-color: #343a40;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      }
      .terminal-title {
        text-align: center;
        color: #ffffff;
      }
      .terminal-input {
        width: 100%;
        padding: 10px;
        border-radius: 5px;
        border: none;
        margin-bottom: 15px;
        font-family: monospace;
        background-color: #495057;
        color: #ffffff;
      }
      .terminal-output {
        background-color: #212529;
        color: #d4d4d4;
        padding: 15px;
        border-radius: 5px;
        font-family: monospace;
        white-space: pre-wrap;
        min-height: 150px;
      }
      .execute-btn {
        width: 100%;
        background-color: #28a745;
        border: none;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
      }
      .execute-btn:hover {
        background-color: #218838;
      }
    </style>
  </head>
  <body>
    <div class="container terminal-container">
      <h1 class="terminal-title">Virtual Terminal</h1>
      <form method="post">
        <input type="text" name="command" placeholder="Enter command" class="terminal-input" value="{{ command }}" />
        <button type="submit" class="execute-btn">Execute</button>
      </form>
      <div class="terminal-output">{{ output }}</div>
    </div>
  </body>
</html>
"""
@app.route('/exp')
def exp():
    # 返回static目录中的exp.html文件
    return send_from_directory('static', 'exp.html')


if __name__ == '__main__':
    app.run(debug=True)
