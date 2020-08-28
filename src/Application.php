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
    protected $context;

    /**
     * Application constructor.
     *
     * @param $context
     */
    public function __construct($context)
    {
        parent::__construct('Propan', '0.1.0');

        $this->context = $context;
    }

    /**
     *
     */
    public function getContext()
    {
        return $this->context;
    }
}
