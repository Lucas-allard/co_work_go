<?php

namespace Core\Infrastructure\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Bundle\MakerBundle\Validator;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * @method string getCommandDescription()
 */
#[AsCommand(
    name: 'make:application:query',
    description: 'Creates a new command'
)]
class MakeApplicationQuery extends AbstractMaker
{

    public function __construct() {}

    public static function getCommandName(): string
    {
        return 'make:application:query';
    }

    public static function getCommandDescription(): string
    {
        return 'Creates a new query';
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
            $filesystem->mkdir("src/$domain/src/Application/Query/$action");
            $this->generateAction($generator, $domain, $action);
        } catch (IOExceptionInterface $ex) {
            echo 'An error occurred while creating tour directory at'.$ex->getPath();
        }
        $this->writeSuccessMessage($io);
    }

    private function generateAction(Generator $generator, string $domain, string $action): void
    {
        $classNameDetails = $generator->createClassNameDetails(
            $action,
            sprintf('%s\\Application\\Query\\%s', $domain, $action)
        );
        $generator->generateFile(
            sprintf(
                "src/%s/src/Application/Query/$action/%s.php",
                $domain,
                $classNameDetails->getShortName()
            ),
            __DIR__ . "/Skeleton/QueryAction.tpl.php",
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