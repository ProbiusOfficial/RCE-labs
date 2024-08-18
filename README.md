# RCE-labs

更新日志：

Level 0 : 代码执行&命令执行 

Level 1 : 一句话木马和代码执行 

Level 2 : PHP代码执行函数 

Level 3 : 命令执行 

Level 4 : 命令执行 - SHELL 运算符 

Level 5 : 命令执行 - 终端特性_空字符忽略和通配符 

Level 6 : 挑战关 

Level 7 : 命令执行 - 终端特殊字符 

Level 8 : 命令执行 - 重定向 

Level 9 : 命令执行 - bash终端的无字母命令执行_$'\xxx' 

Level 10 : 命令执行 - bash终端的无字母命令执行_你真的懂二进制么？ 

Level 11 : 命令执行 - bash终端的无字母命令执行_零溢事件 

Level 12 : 命令执行 - bash终端的无字母命令执行_无字母_1 

Level 13 : 命令执行 - bash终端的无字母命令执行_无字母_2 

Level 14 : 命令执行 - PHP命令执行函数 

Level 15 : 命令执行 - 环境变量注入 

Level 16 : 文件写入导致的RCE 

Level 17 : 文件上传导致的RCE 

Level 18 : 文件包含导致的RCE 

Level 19 : PHP 特性 - 动态调用 

Level 20 : PHP 特性 - 自增 

Level 21 : PHP 特性 - 无参命令执行 

Level 22 : PHP 特性 - 取反绕过 

Level 23 : PHP - 模板注入导致的RCE


## WriteUp

后面慢慢补（）

### Level 1

NULL

### Level 2

#### PHP 代码执行相关函数

| 函数                                                         | 说明                                                         | 示例代码                                                     |
| ------------------------------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ |
| `${}`                                                        | 用于复杂的变量解析，通常在字符串内用来解析变量或表达式。可以配合 `eval` 或其他动态执行代码的功能，用于间接执行代码。 | `eval('${flag}');`                                           |
| [`eval()`](https://www.php.net/manual/zh/function.eval.php)      | 用于执行一个字符串作为 PHP 代码。可以执行任何有效的 PHP 代码片段。没有返回值，除非在执行的代码中明确返回。 | `eval('echo $flag;');`                                       |
| [`assert()`](https://www.php.net/manual/zh/function.assert.php)  | 测试表达式是否为真。PHP 8.0.0 之前，如果 `assertion` 是字符串，将解释为 PHP 代码并通过 `eval()` 执行。<br />**PHP 8.0.0 后移除该功能。** | `assert(print_r($flag));`                                    |
| [`call_user_func()`](https://www.php.net/manual/zh/function.call-user-func.php) | 用于调用回调函数，可以传递多个参数给回调函数，返回回调函数的返回值。适用于动态函数调用。 | `call_user_func('print_r', $flag);`                          |
| [`create_function()`](https://www.php.net/manual/zh/function.create-function.php) | 创建匿名函数，接受两个字符串参数：参数列表和函数体。返回一个匿名函数的引用。<br />**自 PHP 7.2.0 起被*废弃*，并自 PHP 8.0.0 起被*移除*。** | `create_function('$a', 'echo $flag;')($a);`                  |
| [`array_map()`](https://www.php.net/manual/zh/function.array-map.php) | 将回调函数应用于数组的每个元素，返回一个新数组。适用于转换或处理数组元素。 | `array_map(print_r($flag), $a);`                             |
| [`call_user_func_array()`](https://www.php.net/manual/zh/function.call-user-func-array.php) | 调用回调函数，并将参数作为数组传递。适用于动态参数数量的函数调用。 | `call_user_func_array(print_r($flag), array());`             |
| [`usort()`](https://www.php.net/manual/zh/function.usort.php)    | 对数组进行自定义排序，接受数组和比较函数作为参数。适用于根据用户定义的规则排序数组元素。 | `usort($a,print_r($flag));`                                  |
| [`array_filter()`](https://www.php.net/manual/zh/function.array-filter.php) | 过滤数组元素，如果提供回调函数，仅包含回调返回真值的元素；否则，移除所有等同于false的元素。适用于基于条件移除数组中的元素。 | `array_filter($a,print_r($flag));`                           |
| [`array_reduce()`](https://www.php.net/manual/zh/function.array-reduce.php) | 迭代一个数组，通过回调函数将数组的元素逐一减少到单一值。接受数组、回调函数和可选的初始值。 | `array_reduce($a,print_r($flag));`                           |
| [`preg_replace()`](https://www.php.net/manual/zh/function.preg-replace.php) | 执行正则表达式的搜索和替换。可以是单个字符串或数组。适用于基于模式匹配修改文本内容。<br />**依赖 /e 模式，该模式自 PHP7.3 起被取消。** | `preg_replace('/(.*)/ei', 'strtolower("\\1")', ${print_r($flag)});` |
| [`ob_start()`](https://www.php.net/manual/zh/function.ob-start.php) | ob_start — 打开输出控制缓冲,可选回调函数作为参数来处理缓冲区内容。 | `ob_start(print_r($flag));`                                   |



---





| 函数                                                                                               | 说明                                                                                                         | 示例代码                     |
|----------------------------------------------------------------------------------------------------|--------------------------------------------------------------------------------------------------------------|------------------------------|
| [`system()`](https://www.php.net/manual/zh/function.system.php)                                    | `system()` 函数用于在系统权限允许的情况下执行系统命令（Windows 和 Linux 系统均可执行）。                     | `system('cat /etc/passwd');` |
| [`exec()`](https://www.php.net/manual/zh/function.exec.php)                                        | `exec()` 函数可以执行系统命令，但不会直接输出结果，而是将结果保存到数组中。                                   | `exec('cat /etc/passwd', $result); print_r($result);` |
| [`shell_exec()`](https://www.php.net/manual/zh/function.shell-exec.php)                            | `shell_exec()` 函数执行系统命令，但返回一个字符串类型的变量来存储系统命令的执行结果。                         | `echo shell_exec('cat /etc/passwd');` |
| [`passthru()`](https://www.php.net/manual/zh/function.passthru.php)                                | `passthru()` 函数执行系统命令并将执行结果输出到页面中，支持二进制数据。                                       | `passthru('cat /etc/passwd');` |
| [`popen()`](https://www.php.net/manual/zh/function.popen.php)                                      | `popen()` 函数执行系统命令，但返回一个资源类型的变量，需要配合 `fread()` 函数读取结果。                       | `$result = popen('cat /etc/passwd', 'r'); echo fread($result, 100);` |
| [反引号 \`\`](https://www.php.net/manual/zh/language.operators.execution.php)                        | 反引号用于执行系统命令，返回一个字符串类型的变量来存储命令的执行结果。**注意：关闭了 [shell_exec()](https://www.php.net/manual/zh/function.shell-exec.php) 时反引号运算符是无效的** | echo \`cat /etc/passwd` |



---



| 运算符               | 说明                                                         | 示例代码                                                 |
| -------------------- | ------------------------------------------------------------ | -------------------------------------------------------- |
| `&&`（逻辑与运算符） | 只有当第一个命令 `cmd_1` 执行成功（返回值为 0）时，才会执行第二个命令 `cmd_2`。 | `mkdir test && cd test`                                  |
| `||`（逻辑或运算符） | 只有当第一个命令 `cmd_1` 执行失败（返回值不为 0）时，才会执行第二个命令 `cmd_2`。 | `cd nonexistent_directory || echo "Directory not found"` |
| `&`（后台运行符）    | 将命令 `cmd_1` 放到后台执行，Shell 立即执行 `cmd_2`，两个命令并行执行。 | `sleep 10 & echo "This will run immediately."`           |
| `;`（命令分隔符）    | 无论前一个命令 `cmd_1` 是否成功，都会执行下一个命令 `cmd_2`。 | `echo "Hello" ; echo "World"`                            |



---




| 通配符 | 功能说明                                                         | 示例                           | 用途                                             |
|--------|------------------------------------------------------------------|--------------------------------|--------------------------------------------------|
| `*`    | 匹配**零个或多个**字符                                          | `*.txt`                        | 匹配所有以 `.txt` 结尾的文件                     |
| `?`    | 匹配**单个字符**                                                 | `file?.txt`                    | 匹配 `file1.txt`, `file2.txt` 等单个字符的文件名 |
| `[]`   | 匹配方括号内的**任意一个字符**                                   | `file[1-3].txt`                | 匹配 `file1.txt`, `file2.txt`, `file3.txt`       |
| `[^]`  | 匹配**不在方括号内**的字符                                       | `file[^a-c].txt`               | 匹配不包含 `a` 到 `c` 之间字符的文件             |
| `{}`   | 匹配大括号内的**任意一个字符串**，使用逗号分隔                   | `file{1,2,3}.txt`              | 匹配 `file1.txt`, `file2.txt`, `file3.txt`       |
| `~`    | 表示当前用户的**主目录**                                         | `~/Documents`                  | 访问主目录下的 `Documents` 文件夹               |
| `!`    | 表示**取反**，在一些条件测试或模式匹配中使用                     | `ls !(*.txt)`                  | 列出所有不是 `.txt` 结尾的文件                   |
| `\`    | **转义字符**，取消通配符的特殊意义，使其作为普通字符处理         | `file\*.txt`                   | 匹配文件名为 `file*.txt` 的文件                  |



| 函数                | 说明                                                         | 示例代码                                                     |
| ------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| `file_put_contents` | 将字符串写入文件，如果文件不存在会尝试创建。适用于快速简单地写入数据到文件。 | `file_put_contents('example.php', '<?php eval($_GET[helloctf]); ?>');` |
| `fwrite/fputs`      | 向一个打开的文件流写入数据，适用于需要更细粒度的控制文件操作的场景。 | `$fp = fopen('example.php', 'w'); fwrite($fp, '<?php eval($_GET[helloctf]); ?>'); fclose($fp);` |
| `fprintf`           | 类似于 `fwrite`，但提供格式化功能，允许按照特定格式写入数据到文件流。适用于需要格式化写入的场景。 | `$fp = fopen('example.php', 'w'); fprintf($fp, '<?php eval($_GET[helloctf]); ?>'); fclose($fp);` |
