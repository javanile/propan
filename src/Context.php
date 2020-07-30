<?php

namespace Javanile\Propan;

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

class Context
{
    protected $cwd;

    protected $buildPath;

    public function __construct($cwd)
    {
        $this->cwd = $cwd;
        $this->buildPath = $this->cwd.'/.build';
    }

    public function getBuildPath()
    {
        return $this->buildPath;
    }
}
