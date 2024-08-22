<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HelloCTF - RCE靶场 : 文件上传导致的RCE</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .upload-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
            width: 100%;
        }
        .upload-container h2 {
            color: #007BFF;
            margin-bottom: 20px;
        }
        .custom-file-upload {
            display: inline-block;
            padding: 8px 20px;
            cursor: pointer;
            background-color: #007BFF;
            color: white;
            border-radius: 4px;
            font-size: 16px;
        }
        #fileToUpload {
            display: none;
        }
        .upload-container input[type="submit"] {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 15px;
        }
        .upload-container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .message {
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="upload-container">
    <h4>HelloCTF - RCE靶场 : 文件上传导致的RCE</h4>
    <p>默认路径: uploads/</p>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="fileToUpload" class="custom-file-upload">
            选择文件
        </label>
        <input type="file" name="fileToUpload" id="fileToUpload">
        <br>
        <input type="submit" value="上传文件" name="submit">
    </form>

    <div class="message">
    <?php
/*
# -*- coding: utf-8 -*-
# @Author: 探姬
# @Date:   2024-08-11 14:34
# @Repo:   github.com/ProbiusOfficial/RCE-labs
# @email:  admin@hello-ctf.com
# @link:   hello-ctf.com

--- HelloCTF - RCE靶场 : 文件上传导致的RCE --- 

*/
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "文件 ". htmlspecialchars(basename($_FILES["fileToUpload"]["name"])). " 已成功上传.";
        } elseif (!isset($_FILES["fileToUpload"])) {
            echo "请先选择要上传的文件.";
        } else {
            echo "抱歉，文件上传失败.";
        }
    }
    ?>
    </div>
</div>

</body>
</html>


