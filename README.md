Yii 2 Advanced Blog
===============================
`Install application on Linux`

  ```sh
 $ php init   
 php composer install
 php yii migrate --migrationPath=@yii/rbac/migrations
 php yii rbac/init
 php yii migrate
 ```
 `Main routes`
 
 ```sh
 domain.com - Main application(frontend)
 domain.com/admin - Main application(backend)
 ```
 
`Nginx vhosts settings`
```sh
server {
    charset      utf-8;
    client_max_body_size  200M;

    listen       80; ## listen for ipv4
    #listen       [::]:80 default_server ipv6only=on; ## listen for ipv6

    server_name  umber.loc;
    root         /home/nick/Server/umber;

    location / {
        root  /home/nick/Server/umber/frontend/web;

        try_files  $uri /frontend/web/index.php?$args;

        # avoiding processing of calls to non-existing static files by Yii
        location ~ \.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar)$ {
            access_log  off;
            expires  360d;

            try_files  $uri =404;
        }
    }

    location /admin {
        alias  /home/nick/Server/umber/backend/web;

        rewrite  ^(/admin)/$ $1 permanent;
        try_files  $uri /backend/web/index.php?$args;
    }

    # avoiding processing of calls to non-existing static files by Yii
    location ~ ^/admin/(.+\.(js|css|png|jpg|gif|swf|ico|pdf|mov|fla|zip|rar))$ {
        access_log  off;
        expires  360d;

        rewrite  ^/admin/(.+)$ /backend/web/$1 break;
        rewrite  ^/admin/(.+)/(.+)$ /backend/web/$1/$2 break;
        try_files  $uri =404;
    }

    location ~ \.php$ {
        include  fastcgi_params;
        # check your /etc/php5/fpm/pool.d/www.conf to see if PHP-FPM is listening on a socket or port
        fastcgi_pass  unix:/var/run/php5-fpm.sock; ## listen for socket
        #fastcgi_pass  127.0.0.1:9000; ## listen for port
        fastcgi_param  SCRIPT_FILENAME $document_root$fastcgi_script_name;
        try_files  $uri =404;
    }
    #error_page  404 /404.html;

    location = /requirements.php {
        deny all;
    }

    location ~ \.(ht|svn|git) {
        deny all;
    }
} 
  ```
