<?php

namespace Javanile\Propan\Activities;

use bar\baz\source_with_namespace;
use GuzzleHttp\Client;
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

class Build
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
    public function __construct($context)
    {
        $this->context = $context;
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        file_put_contents($this->context->getBuildPath().'/composer.json', json_encode([
            'name' => 'propan/propan',
            'version' => '0.1.0',
        ]));

        $layers = $this->context->getLayers();

        foreach ($layers as $layer) {
            $command = 'require '.$layer;
            $this->context->runCommands([$command], $this->context->getBuildPath(), $input, $output);
        }
    }
}
