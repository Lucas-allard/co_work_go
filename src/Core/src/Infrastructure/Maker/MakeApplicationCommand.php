<?php

namespace Core\Infrastructure\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Bundle\MakerBundle\Str;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @method string getCommandDescription()
 */
#[AsCommand(
    name: 'make:application:command',
    description: 'Creates a new command'
)]
class MakeApplicationCommand extends AbstractMaker
{

    public static function getCommandName(): string
    {
        return 'make:application:command';
    }

    public static function getCommandDescription(): string
    {
        return 'Creates a new command';
    }

    private static function getDirList(string $domain): string
    {
        return 'src' . DIRECTORY_SEPARATOR . $domain . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Application' . DIRECTORY_SEPARATOR . 'Command';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command->addArgument(
            'domain',
            InputArgument::REQUIRED,
            'Enter the domain name'
        )->addArgument(
            'action',
            InputArgument::REQUIRED,
            'Enter the action name'
        );
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
        $dependencies->addClassDependency(
            Filesystem::class,
            'filesystem'
        );
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $domain = Str::asCamelCase(trim($input->getArgument('domain')));
        $action = Str::asCamelCase(trim($input->getArgument('action')));
        $filesystem = new Filesystem();
        try {
            $filesystem->mkdir(self::getDirList($domain));
            $this->generateAction($generator, $domain, $action);
            $this->generateCommand($generator, $domain, $action);
            $this->generateHandler($generator, $domain, $action);
        } catch (IOExceptionInterface $exception) {
            echo 'An error occurred while creating tour directory at'.$exception->getPath();
        }
        $this->writeSuccessMessage($io);
    }

    private function generateAction(Generator $generator, string $domain, string $action): void
    {
        $classNameDetails = $generator->createClassNameDetails(
            $action,
            sprintf('%s\\Application\\Command\\%s', $domain, $action)
        );
        $generator->generateFile(
            sprintf(
                "src/%s/src/Application/Command/$action/%s.php",
                $domain,
                $classNameDetails->getShortName()
            ),
            __DIR__ . "/Skeleton/CommandAction.tpl.php",
            ['domain' => $domain, 'action' => $action]
        );
        $generator->writeChanges();
    }

    private function generateCommand(Generator $generator, string $domain, string $action): void
    {
        $classNameDetails = $generator->createClassNameDetails(
            $action."Command",
            sprintf('%s\\Application\\Command\\%s', $domain, $action)
        );
        $generator->generateFile(
            sprintf(
                "src/%s/src/Application/Command/$action/%s.php",
                $domain,
                $classNameDetails->getShortName()
            ),
            __DIR__ . "/Skeleton/Command.tpl.php",
            ['domain' => $domain, 'action' => $action]
        );
        $generator->writeChanges();
    }

    private function generateHandler(Generator $generator, string $domain, string $action): void
    {
        $classNameDetails = $generator->createClassNameDetails(
            $action."Handler",
            sprintf('%s\\Application\\Command\\%s', $domain, $action)
        );
        $generator->generateFile(
            sprintf(
                "src/%s/src/Application/Command/$action/%s.php",
                $domain,
                $classNameDetails->getShortName()
            ),
            __DIR__ . "/Skeleton/CommandHandler.tpl.php",
            ['domain' => $domain, 'action' => $action]
        );
        $generator->writeChanges();
    }

    public function interact(InputInterface $input, ConsoleStyle $io, Command $command): void
    {
        if (!$input->getArgument('domain')) {
            $question = new Question('Domain name');
            $question->setValidator([Validator::class, 'notBlank']);
            $entityClassName = $io->askQuestion($question);
            $input->setArgument('domain', $entityClassName);
        }
        if (!$input->getArgument('action')) {
            $question = new Question('Action name');
            $question->setValidator([Validator::class, 'notBlank']);
            $entityClassName = $io->askQuestion($question);
            $input->setArgument('action', $entityClassName);
        }
    }
}