<?php

namespace Javanile\Propan\Functions;

use bar\baz\source_with_namespace;
use GuzzleHttp\Client;
use Javanile\Propan\Support\FileUtils;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;
use ZipArchive;

abstract class AbstractFunction
{
    /**
     * The current port offset.
     *
     * @var int
     */
    protected $context;

    /**
     * @param $context
     */
    public function __construct($context, $output)
    {
        $this->context = $context;
    }

    /**
     * @return mixed
     */
    abstract public function execute();
}
