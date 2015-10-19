# 锐思达预约系统

项目开发中.....

## Mac 环境搭建

* 安装相关软件包

* 下载phpstorm, 配置xdebug 请先配置完php运行环境后,查看百度/google教程

```Bash
brew update
brew tap homebrew/dupes
brew tap josegonzalez/homebrew-php
brew install php56 php56-mcrypt php56-xdebug openssl mariadb nginx composer
```

* 创建服务脚本

```Bash
sudo cp -v /usr/local/opt/nginx/*.plist /Library/LaunchDaemons/
sudo chown root:wheel /Library/LaunchDaemons/homebrew.mxcl.nginx.plist
mkdir -p ~/Library/LaunchAgents
ln -sfv /usr/local/opt/php56/homebrew.mxcl.php56.plist ~/Library/LaunchAgents/
ln -sfv /usr/local/opt/mysql/*.plist ~/Library/LaunchAgents
```
* 编辑nginx.conf文件

```Bash
vi /usr/local/etc/nginx/nginx.conf
```

* 我的 nginx.conf 配置,供参考

```nginx
user root owner;
worker_processes  1;

error_log  /usr/local/etc/nginx/logs/error.log debug;

events {
    worker_connections  1024;
}

http {
    include             mime.types;
    default_type        application/octet-stream;

    log_format  main  '$remote_addr - $remote_user [$time_local] "$request" '
                      '$status $body_bytes_sent "$http_referer" '
                      '"$http_user_agent" "$http_x_forwarded_for"';
    client_max_body_size 8M;
    client_body_buffer_size 128k;

    access_log  /usr/local/etc/nginx/logs/access.log  main;

    sendfile            on;

    keepalive_timeout   65;

    index index.html index.php;

    include /usr/local/etc/nginx/sites-enabled/*;
}
```


```Bash
mkdir /usr/local/etc/nginx/sites-available
mkdir /usr/local/etc/nginx/sites-enabled
vi /usr/local/etc/nging/sites-available/default
```

* 我的 default 配置,供参考

```nginx
server {
        listen  80;
        server_name localhost;
        set $root_path '{your path}/restart-reserve/public';
        root $root_path;

        access_log  /usr/local/etc/nginx/logs/default.access.log  main;
        error_log  /usr/local/etc/nginx/logs/default.error.log  error;

        charset utf-8;

        index index.php index.html index.htm;

        # Disallow access to hidden files (.htaccess, .git, etc.)
        location ~ /\. {
                deny all;
        }

        location ~ ^/(robots.txt|favicon.ico)(/|$) {
                try_files $uri =404;
        }

        # serve static files directly
        location ~* \.(jpg|jpeg|gif|css|png|js|ico|html|eot|svg|ttf|woff|woff2|otf)$ {
                access_log off;
                #expires max;
        }

        location / {
                try_files \$uri \$uri/ /index.php?\$query_string;
        }

        location ~ \.php {
                try_files $uri =404;
                fastcgi_keep_conn on;
                fastcgi_split_path_info ^(.+\.php)(/.+)$;
                fastcgi_pass 127.0.0.1:9001;
                fastcgi_index index.php;
                include fastcgi_params;
                fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
                fastcgi_intercept_errors off;
                fastcgi_buffer_size 16k;
                fastcgi_buffers 4 16k;
        }

        error_page  404     /404.html;
        error_page  403     /403.html;
        error_page  500 502 503 504  /50x.html;
        location = /50x.html {
                root   $root_path;
        }
}

```

```Bash
sudo ln -s /usr/local/etc/nginx/sites-available/default /usr/local/etc/nginx/sites-enabled/default
```

* 创建服务启动/关闭别名文件

```Bash
vi ~/.bash_aliases
```

* Bash aliases content

```Bash
alias nginx.start='sudo launchctl load /Library/LaunchDaemons/homebrew.mxcl.nginx.plist'
alias nginx.stop='sudo launchctl unload /Library/LaunchDaemons/homebrew.mxcl.nginx.plist'
alias nginx.restart='nginx.stop && nginx.start'
alias php-fpm.start="launchctl load -w ~/Library/LaunchAgents/homebrew.mxcl.php56.plist"
alias php-fpm.stop="launchctl unload -w ~/Library/LaunchAgents/homebrew.mxcl.php56.plist"
alias php-fpm.restart='php-fpm.stop && php-fpm.start'
alias nginx.logs.error='tail -250f /usr/local/etc/nginx/logs/error.log'
alias nginx.logs.access='tail -250f /usr/local/etc/nginx/logs/access.log'
alias nginx.logs.default.access='tail -250f /usr/local/etc/nginx/logs/default.access.log'
```
* 添加 .bash_aliases 至你的 .profile

```Bash
echo "source ~/.base_aliases" >> ~/.profile
```

* 启动/停止 nginx, php-fpm, mariadb ,查看nginx日志命令

```Bash
nginx.start
nginx.stop
nginx.restart

php-fpm.start
php-fpm.stop
php-fpm.restart

mysql.start
mysql.stop
mysql.restart

nginx.logs.access
nginx.logs.default.access
nginx.logs.error

```

* 创建Mysql数据库和用户,详细请查看百度,google等教程


* 下载项目代码

```Bash
git clone https://github.com/Kangaroos/restart-reserve.git
chmod -R 777 restart-reserve/
cd restart-reserve
composer install
npm install
php artisan migrate
cp .env.example .env
vi .env
```

* 编辑.env文件,修改APP_KEY值(随机生成一串)与config/app.php中的APP_KEY(可修改)值保持相同即可,修改DB相关配置为你的数据库配置

```Bash
cd restart-reserve/resources/assets/vendor
git clone https://github.com/Kangaroos/Semantic-UI.git
cd Semantic-UI
npm install
```

* 新打开一个命令行

```Bash
cd restart-reserve
gulp build-semantic
gulp watch-semantic
```

* 另外再打开一个命令行
```Bash
cd restart-reserve
gulp
```

* 启动nginx,php-fpm,mariadb,访问http://localhost 查看是否部署成功,开始开发

