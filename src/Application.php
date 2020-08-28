<?php

namespace Javanile\Propan;

use Symfony\Component\Console\Application as ConsoleApplication;

class Application extends ConsoleApplication
{
    /**
     * Application configuration.
     *
     * @param $context
     */
    protected $cwd;

    /**
     * Application constructor.
     *
     * @param $context
     */
    public function __construct($cwd)
    {
        parent::__construct('Propan', '0.1.0');

        $this->cwd = $cwd;
    }

    /**
     *
     */
    public function getCwd()
    {
        return $this->cwd;
    }
}
