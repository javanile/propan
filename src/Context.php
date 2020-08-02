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

    protected $configFile;

    protected $config;

    public function __construct($cwd)
    {
        $this->cwd = $cwd;
    }

    public function initialize($path, $output)
    {
        $this->path = $path;
        $this->buildPath = $this->cwd.'/.build';
        $this->configFile = $this->cwd.'/Propan.json';

        if (!file_exists($this->configFile)) {
            echo "Propan.json not found current directory";
            exit(1);
        }

        $this->config = json_decode(file_get_contents($this->configFile), true);
    }

    public function getBuildPath()
    {
        return $this->buildPath;
    }


    public function getLayers()
    {
        return $this->config['layers'];
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    public function findComposer()
    {
        $composerPath = getcwd().'/composer.phar';

        if (file_exists($composerPath)) {
            return '"'.PHP_BINARY.'" '.$composerPath;
        }

        return 'composer';
    }

    /**
     *
     */
    public function runCommands($commands, $directory, $input, $output)
    {
        $composer = $this->findComposer();

        $commands = array_map(function ($value) use ($composer) {
            return $composer . ' ' . $value;
        }, $commands);

        /*
        if ($input->getOption('no-ansi')) {
            $commands = array_map(function ($value) {
                return $value.' --no-ansi';
            }, $commands);
        }

        if ($input->getOption('quiet')) {
            $commands = array_map(function ($value) {
                return $value.' --quiet';
            }, $commands);
        }
        */

        $process = Process::fromShellCommandline(implode(' && ', $commands), $directory, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $output->writeln('Warning: '.$e->getMessage());
            }
        }

        $process->run(function ($type, $line) use ($output) {
            $output->write($line);
        });

        return $process;
    }

}
