<?php

namespace Javanile\Propan\Tests;

use Javanile\Propan\Commands\BuildCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Filesystem\Filesystem;

class BuildCommandTest extends TestCase
{
    public function test_it_can_scaffold_a_new_blog()
    {
        $scaffoldDirectoryName = 'tests/output/my-blog';
        $scaffoldDirectory = __DIR__.'/../'.$scaffoldDirectoryName;

        if (file_exists($scaffoldDirectory)) {
            (new Filesystem)->remove($scaffoldDirectory);
        }

        $app = new Application();
        $app->add(new NewCommand);

        $tester = new CommandTester($app->find('build'));

        $statusCode = $tester->execute(['name' => $scaffoldDirectoryName, '--from' => 'blog']);

        $this->assertEquals($statusCode, 0);
        $this->assertDirectoryExists($scaffoldDirectory.'/vendor');
        $this->assertFileExists($scaffoldDirectory.'/.env');
    }
}
