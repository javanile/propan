<?php

namespace Javanile\Propan;

class Application extends \Symfony\Component\Console\Application
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
