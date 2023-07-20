<?php

namespace Core\Infrastructure\Maker;

use SimpleXMLElement;
use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @method string getCommandDescription()
 */

final class MakeDomain extends AbstractMaker
{

    /**
     * @param string $projectDir
     */
    public function __construct(
        private string $projectDir
    ) {
    }

    /**
     * @return string
     */
    public static function getCommandName(): string
    {
        return 'make:domain';
    }

    /**
     * @return string
     */
    public static function getCommandDescription(): string
    {
        return 'Creates a new domain directory structure';
    }

    /**
     * @param Command $command
     * @param InputConfiguration $inputConfig
     * @return void
     */
    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command->addArgument(
            'name',
            InputArgument::REQUIRED,
            'Choose a domain name'
        );
    }

    /**
     * @param DependencyBuilder $dependencies
     * @return void
     */
    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        $dependencies->addClassDependency(
            Filesystem::class,
            'filesystem'
        );
    }

    /**
     * @param InputInterface $input
     * @param ConsoleStyle $io
     * @param Generator $generator
     * @return void
     */
    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $domain = Str::asCamelCase(trim($input->getArgument('name')));
        $filesystem = new Filesystem();
        try {
            $filesystem->mkdir(self::getDirList($domain));
            $this->generateConfigFiles($generator, $domain);
            $this->updateComposerJson($domain);
            $io->comment('<fg=yellow>updated</>: composer.json');
            $this->updateDoctrineProjectConfig($domain);
            $io->comment('<fg=yellow>updated</>: config/packages/doctrine.php');
            $this->updateContainerProjectConfig($domain);
            $io->comment('<fg=yellow>updated</>: config/services.php');
            $this->updatePhpUnitXml($domain);
            $io->comment('<fg=yellow>updated</>: phpunit.xml.dist');
        } catch (IOExceptionInterface $ex) {
            echo 'An error occurred while creating tour directory at' . $ex->getPath();
        }
        $this->writeSuccessMessage($io);
        $io->text("Don't forget to execute `composer dump-autoload` !");
    }

    /**
     * @param string $domain
     * @return string[]
     */
    private static function getDirList(string $domain): array
    {
        return [
            // config
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'config',
            // Application
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Application',
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Application' . DIRECTORY_SEPARATOR . 'Command',
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Application' . DIRECTORY_SEPARATOR . 'Query',
            // Domain
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Domain',
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Domain' . DIRECTORY_SEPARATOR . 'Entity',
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Domain' . DIRECTORY_SEPARATOR . 'ValueObject',
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Domain' . DIRECTORY_SEPARATOR . 'Repository',
            // Infrastructure
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Infrastructure',
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Infrastructure' . DIRECTORY_SEPARATOR . 'Entity',
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Infrastructure' . DIRECTORY_SEPARATOR . 'Repository',
            // Presentation
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Presentation',
            // Tests
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'tests',
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'Mock',
            'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'Unit'
        ];
    }

    /**
     * @param Generator $generator
     * @param string $domain
     * @return void
     */
    private function generateConfigFiles(Generator $generator, string $domain): void
    {
        $files = ['ContainerConfig', 'DoctrineConfig'];
        foreach ($files as $fileName) {
            $classNameDetails = $generator->createClassNameDetails(
                $fileName,
                'src\\' . $domain . '\\src\\config'
            );
            $generator->generateFile(
                sprintf(
                    'src/%s/src/config/%s.php',
                    $domain,
                    $classNameDetails->getShortName()
                ),
                __DIR__."/Skeleton/$fileName.tpl.php",
                ['domain' => $domain]
            );
            $generator->writeChanges();
        }
    }

    /**
     * @param string $domain
     * @return void
     */
    private function updateComposerJson(string $domain): void
    {
        $composerJson = file_get_contents($this->projectDir.'/composer.json');
        if($composerJson){
            $composerArray = json_decode($composerJson, true);
            $composerArray['autoload']['psr-4']["$domain\\"] = "src" . DIRECTORY_SEPARATOR . "$domain" . DIRECTORY_SEPARATOR . "src";
            $composerArray['autoload-dev']['psr-4']["$domain\\Tests\\"] = "src" . DIRECTORY_SEPARATOR . "$domain" . DIRECTORY_SEPARATOR . "tests";
            file_put_contents($this->projectDir.'/composer.json', json_encode($composerArray));
        }
    }

    /**
     * @param string $domain
     * @return void
     */
    private function updateDoctrineProjectConfig(string $domain): void
    {
        $config = file_get_contents($this->projectDir.'/config/packages/doctrine.php');
        if($config){
            $config = str_replace(
                "};\n",
                "\t\\$domain\\config\\DoctrineConfig::configure(\$emDefault);\n};\n",
                $config
            );
            file_put_contents($this->projectDir.'/config/packages/doctrine.php', $config);
        }
    }

    /**
     * @param string $domain
     * @return void
     */
    private function updateContainerProjectConfig(string $domain): void
    {
        $config = file_get_contents($this->projectDir.'/config/services.php');
        if($config){
            $config = str_replace(
                "};\n",
                "\t\\$domain\\config\\ContainerConfig::configure(\$services);\n};\n",
                $config
            );
            file_put_contents($this->projectDir.'/config/services.php', $config);
        }
    }

    /**
     * @param string $domain
     * @return void
     */
    private function updatePhpUnitXml(string $domain): void
    {
        $config = simplexml_load_file($this->projectDir.'/phpunit.xml.dist');
        if($config){
            $config->testsuites[0]->testsuite[0]->directory[] = new SimpleXMLElement("<directory>src/$domain/tests</directory>");
            $config->saveXML($this->projectDir.'/phpunit.xml.dist');
        }
    }
}