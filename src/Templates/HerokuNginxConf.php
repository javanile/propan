<?php

namespace Javanile\Propan\Activities\Templates;

class HerokuNginxConf
{
    public static function fileContent()
    {
        return <<<EOF
location / {
    try_files \$uri @rewriteapp;
}

location @rewrite {
    rewrite ^(.*)$ /index.php/$1 last;
}

location ~ ^/index\.php(/|$) {
    try_files @heroku-fcgi @heroku-fcgi;
    internal;
}
EOF;
    }
}
