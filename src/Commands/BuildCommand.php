<?php

namespace Javanile\Propan\Commands;

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

class BuildCommand extends BaseCommand
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('build')
            ->setDescription('Build a bundle from a Propan.json file')
            ->addArgument('path', InputArgument::REQUIRED)
            //->addOption('path', null, InputOption::VALUE_REQUIRED, 'Install on specific path', getcwd());
        ;
    }

    /**
     * Execute the command.
     *
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');

        /*
        $this->checkExtensions();

        $directory = $input->getOption('path');

        //if (! $input->getOption('force')) {
        //    $this->verifyApplicationDoesntExist($directory);
        //}


        $output->writeln('<info>Registry lookup...</info>');

        $brickUrl = $this->registryLookup($brick);
        $brickFile = $this->tempFile();
        $tempDir = $this->tempDir();

        $this->download($brickUrl, $brickFile)
             ->extract($brickFile, $tempDir);

        $config = $this->configLookup($tempDir);

        if (isset($config['files'])) {
            $this->copyFiles($config['files'], $tempDir, $directory);
        }

        $commands = ['install --no-scripts'];

        $commands = $this->appendRequire($commands, $config);

        $commands = $this->appendRequireDev($commands, $config);

        $commands = $this->appendPostAdd($commands, $config);

        $process = $this->runCommands($commands, $directory, $input, $output);

        if ($process->isSuccessful()) {
            $output->writeln('<comment>Brick successful added.</comment>');
        }
        */

        $output->writeln('<comment>Brick successful added.</comment>');

        $context = $this->getApplication()->getContext();

        $context->initialize($path, $output);

        $buildActivity = new \Javanile\Propan\Functions\Build($context);

        $buildActivity->execute($input, $output);

        return 0;
    }
}
