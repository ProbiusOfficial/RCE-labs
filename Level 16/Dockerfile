FROM php:7.3-fpm-alpine

# 制作者信息
LABEL auther_template="CTF-Archives"

# 安装必要的软件包
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.ustc.edu.cn/g' /etc/apk/repositories  &&\
    apk add --update --no-cache nginx bash coreutils

#修改指向
RUN ln -sf /bin/bash /bin/sh

# 拷贝容器入口点脚本
COPY ./service/docker-entrypoint.sh /docker-entrypoint.sh
RUN chmod +x /docker-entrypoint.sh

# 复制nginx配置文件
COPY ./config/nginx.conf /etc/nginx/nginx.conf
# COPY ./config/php.ini /usr/local/etc/php/conf.d

# 复制web项目源码
COPY *.php /var/www/html/

# 重新设置源码路径的用户所有权
RUN chown -R www-data:www-data /var/www/html
 
# 设置shell的工作目录
WORKDIR /var/www/html

# 根据题目提前创建沙盒目录并授权
RUN mkdir -p /www/sandbox
RUN chown -R www-data:www-data /www

# [可选]指定对外暴露端口，对于GZCTF等平台，强制EXPOSE可能会造成非预期端口泄露，请酌情启用
# EXPOSE 80

# 设置nginx日志保存目录
VOLUME ["/var/log/nginx"]

# 设置容器入口点
ENTRYPOINT [ "/docker-entrypoint.sh" ]
