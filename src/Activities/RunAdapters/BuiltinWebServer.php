<?php

namespace Javanile\Propan\Activities\RunAdapters;

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
use Symfony\Component\Process\PhpExecutableFinder;
use Javanile\Propan\Support\ProcessUtils;
use ZipArchive;

class BuiltinWebServer
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Serve the application on the PHP development server';

    /**
     * The current port offset.
     *
     * @var int
     */
    protected $portOffset = 0;

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

    /**
     * Execute the console command.
     *
     * @return int
     *
     * @throws \Exception
     */
    public function execute()
    {
        $publicPath = $this->context->getBuildPath().'/public';

        chdir($publicPath);

        //$this->line("<info>Laravel development server started:</info> http://{$this->host()}:{$this->port()}");

        passthru($this->serverCommand(), $status);

        if ($status && $this->canTryAnotherPort()) {
            $this->portOffset += 1;

            return $this->handle();
        }

        return $status;
    }

    /**
     * Get the full server command.
     *
     * @return string
     */
    protected function serverCommand()
    {
        $serverFile = $this->context->getBuildPath().'/server.php';

        return sprintf('%s -S %s:%s %s',
            ProcessUtils::escapeArgument((new PhpExecutableFinder)->find(false)),
            $this->host(),
            $this->port(),
            ProcessUtils::escapeArgument($serverFile)
        );
    }

    /**
     * Get the host for the command.
     *
     * @return string
     */
    protected function host()
    {
        //return $this->input->getOption('host');
        return '127.0.0.1';
    }

    /**
     * Get the port for the command.
     *
     * @return string
     */
    protected function port()
    {/*
        $port = $this->input->getOption('port') ?: 8000;

        return $port + $this->portOffset;
    */
        return '8080';
    }

    /**
     * Check if command has reached its max amount of port tries.
     *
     * @return bool
     */
    protected function canTryAnotherPort()
    {
        //return is_null($this->input->getOption('port')) &&
        //    ($this->input->getOption('tries') > $this->portOffset);
        return false;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            //['host', null, InputOption::VALUE_OPTIONAL, 'The host address to serve the application on', '127.0.0.1'],

            //['port', null, InputOption::VALUE_OPTIONAL, 'The port to serve the application on', Env::get('SERVER_PORT')],

            //['tries', null, InputOption::VALUE_OPTIONAL, 'The max number of ports to attempt to serve from', 10],
        ];
    }
}
