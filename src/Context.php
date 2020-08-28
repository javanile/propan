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
use Symfony\Component\Yaml\Yaml;
use ZipArchive;

class Context
{
    /**
     * @var
     */
    protected $cwd;

    /**
     * @var string
     */
    protected $propanFile;

    /**
     * @var
     */
    protected $rawData;

    /**
     * @var
     */
    protected $buildPath;

    /**
     * Context constructor.
     *
     * @param $cwd
     * @param $output
     */
    public function __construct($cwd, $output)
    {
        $this->cwd = $cwd;
        $this->propanFile = $this->cwd.'/Propan.yml';
        $this->buildPath = $this->cwd.'/build';
    }

    /**
     *
     * @return bool
     */
    public function check()
    {

        var_dump($this->rawData);
    }

    /**
     * @param $path
     */
    public function initialize()
    {
        if (!file_exists($this->propanFile)) {
            echo 'Propan.yml not found in: '.dirname($this->propanFile)."\n";
            return false;
        }
        //$this->path = $path;

        $this->rawData = Yaml::parseFile($this->propanFile);
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
