<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RegEx Helper</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
        }
        input[type="submit"] {
            padding: 10px 20px;
        }
        .result {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h1>RegEx Helper</h1>
    <form action="reg_helper.php" method="POST">
        <label for="regex">请输入正则表达式：</label><br>
        <input type="text" id="regex" name="regex" required placeholder="例如：[0-9]|\~|\@|\#"><br>
        <input type="submit" value="获取可用字符">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $regex = isset($_POST['regex']) ? $_POST['regex'] : '';

        $all_chars = array_merge(range(chr(32), chr(126)));
        $usable_chars = "";
        $usable_chars_urlformat = "";
        $unusable_chars = "";


        foreach ($all_chars as $char) {
            if (!preg_match("/$regex/i", $char)) {
                $usable_chars .= $char . " ";
                $usable_chars_urlformat .= rawurlencode($char) . " ";
            }else{
                $unusable_chars .= $char . " ";
            }
        }

        echo '<div class="result"><h2>不可用字符:</h2>';
        echo '<p>' . htmlspecialchars($unusable_chars) . '</p></div>';

        echo '<div class="result"><h2>可用字符:</h2>';
        echo '<p>' . htmlspecialchars($usable_chars) . '</p></div>';
        echo '<p>' . htmlspecialchars($usable_chars_urlformat) . '</p></div>';
    }
    ?>
</body>
</html>
