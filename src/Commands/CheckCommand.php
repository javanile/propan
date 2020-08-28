<?php

namespace Javanile\Propan\Commands;

use GuzzleHttp\Client;
use Javanile\Propan\Context;
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

class CheckCommand extends BaseCommand
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('check')
            ->setDescription('Check current for build or runtime')
            //->addOption('path', null, InputOption::VALUE_REQUIRED, 'Install on specific path', getcwd())
            ;
    }

    /**
     * Execute the command.
     *
     * @param  InputInterface  $input
     * @param  OutputInterface  $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->checkExtensions();

        $cwd = $this->getApplication()->getCwd();

        $context = new Context($cwd, $output);
        $context->initialize();

        $context->check();

        return 0;
    }
}
