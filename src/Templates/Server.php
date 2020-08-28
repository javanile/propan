<?php

namespace Javanile\Propan\Activities\Templates;

class Server
{
    public static function fileContent()
    {
        return <<<EOF
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

\$uri = urldecode(parse_url(\$_SERVER['REQUEST_URI'], PHP_URL_PATH));

// This file allows us to emulate Apache's "mod_rewrite" functionality from the
// built-in PHP web server. This provides a convenient way to test a Laravel
// application without having installed a "real" web server software here.
if (\$uri !== '/' && file_exists(__DIR__.'/public'.\$uri))
{
return false;
}

if (\$uri !== '/' && file_exists(__DIR__ . '/files' . \$uri)) {
    mkdir(dirname(__DIR__ . '/public' . \$uri), 0777, true);
    copy(__DIR__ . '/files' . \$uri, __DIR__ . '/public' . \$uri);
    return false;
}

require_once __DIR__ . '/public/index.php';

EOF;
    }
}