<?php

namespace Javanile\Propan\Activities\Templates;

class PublicIndex
{
    public static function fileContent()
    {
        return <<<EOF
<?php

set_include_path(__DIR__.'/../files');

require_once __DIR__.'/../files/index.php';

EOF;
    }
}
