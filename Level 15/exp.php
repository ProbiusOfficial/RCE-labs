<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BashFuck Payload Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
            color: #333;
        }
        h1 {
            color: #333;
        }
        .input-container, .output-container {
            margin-bottom: 20px;
        }
        textarea, .output-container textarea {
            width: 100%;
            padding: 10px;
            font-family: monospace;
            border: 2px solid #4a90e2;
            border-radius: 8px;
            resize: none;
            font-size: 14px;
            background-color: #f0f8ff;
            outline: none;
            box-sizing: border-box;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            margin-top: 10px;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.2);
        }
        button:hover {
            background-color: #357ab8;
        }
        .container {
            margin-bottom: 30px;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border: 2px solid #ddd;
            box-sizing: border-box;
        }
        .payload-info {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 14px;
        }
        .copy-btn {
            float: right;
            padding: 8px 15px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }
        .copy-btn:hover {
            background-color: #357ab8;
        }
        .output-container {
            display: flex;
            flex-direction: column;
        }
    </style>
</head>
<body>

<h1>BashFuck Payload Generator</h1>
<p>Enter your command below and generate the payloads for all formats.</p>

<div class="input-container">
    <textarea id="cmdInput" placeholder="Enter command here..." rows="3"></textarea>
    <button onclick="generatePayload()">Generate Payloads</button>
</div>

<div id="output" class="output-container"></div>

<script>
function info(s) {
    let total = 0;
    let usedChars = new Set();
    for (let c of s) {
        if (c.match(/[ -~]/) && !usedChars.has(c)) {  
            total++;
            usedChars.add(c);
        }
    }
    return {
        charset: Array.from(usedChars).sort().join(' '),
        totalUsed: total,
        payloadLength: s.length,
        payload: s
    };
}

function getOct(c) {
    return c.charCodeAt(0).toString(8);  // 将字符的ASCII值转换为八进制字符串
}

function nomalOtc(cmd) {
    let payload = "$'";
    for (let c of cmd) {
        payload += '\\' + getOct(c);
    }
    payload += "'";
    return info(payload);
}

function bashfuckX(cmd, form) {
    let bashStr = '';
    for (let c of cmd) {
        let binaryStr = parseInt(getOct(c), 10).toString(2);
        bashStr += '\\\\$(($((1<<1))#' + binaryStr + '))';
    }

    let payloadBit = bashStr;
    let payloadZero = bashStr.replace(/1/g, '${##}');  // 用 ${##} 来替换 1
    let payloadC = bashStr.replace(/1/g, '${##}').replace(/0/g, '${#}');  // 用 ${#} 来替换 0

    if (form === 'bit') {
        payloadBit = '$0<<<$0\\<\\<\\<\\$\\\'' + payloadBit + '\\\'';
        return info(payloadBit);
    } else if (form === 'zero') {
        payloadZero = '$0<<<$0\\<\\<\\<\\$\\\'' + payloadZero + '\\\'';
        return info(payloadZero);
    } else if (form === 'c') {
        payloadC = '${!#}<<<${!#}\\<\\<\\<\\$\\\'' + payloadC + '\\\'';
        return info(payloadC);
    }
}

function bashfuckY(cmd) {
    let octList = [
        '$(())',  // 0
        '$((~$(($((~$(())))$((~$(())))))))',  // 1
        '$((~$(($((~$(())))$((~$(())))$((~$(())))))))',  // 2
        '$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))))))',  // 3
        '$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))))))',  // 4
        '$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))))))',  // 5
        '$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))))))',  // 6
        '$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))))))',  // 7
    ];
    let bashFuck = '';
    bashFuck += '__=$(())';  // set __ to 0
    bashFuck += '&&';  // splicing
    bashFuck += '${!__}<<<${!__}\\<\\<\\<\\$\\\'';  // got 'sh'

    for (let c of cmd) {
        bashFuck += '\\\\';
        for (let i of getOct(c)) {
            bashFuck += octList[parseInt(i)];
        }
    }

    bashFuck += '\\\'';
    return info(bashFuck);
}

function generatePayload() {
    const cmd = document.getElementById("cmdInput").value;
    const outputDiv = document.getElementById("output");
    outputDiv.innerHTML = '';  // 清空之前的输出

    const payloads = [
        { title: 'Normal OTC', data: nomalOtc(cmd) },
        { title: 'Bit', data: bashfuckX(cmd, 'bit') },
        { title: 'Zero', data: bashfuckX(cmd, 'zero') },
        { title: 'C', data: bashfuckX(cmd, 'c') },
        { title: 'Bashfuck Y', data: bashfuckY(cmd) }
    ];

    payloads.forEach(payload => {
        const container = document.createElement('div');
        container.classList.add('container');

        const info = document.createElement('div');
        info.classList.add('payload-info');
        info.innerHTML = `Charset (${payload.data.totalUsed}) : ${payload.data.charset}<br>Payload length = ${payload.data.payloadLength}`;
        container.appendChild(info);

        const textarea = document.createElement('textarea');
        textarea.value = payload.data.payload;
        textarea.readOnly = true;
        textarea.rows = 4;
        container.appendChild(textarea);

        const copyButton = document.createElement('button');
        copyButton.classList.add('copy-btn');
        copyButton.innerText = 'Copy';
        copyButton.onclick = () => {
            textarea.select();
            document.execCommand('copy');
        };
        container.appendChild(copyButton);

        outputDiv.appendChild(container);
    });
}
</script>

</body>
</html>