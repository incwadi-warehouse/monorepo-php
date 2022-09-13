<?php

namespace Baldeweg\Bundle\ApiBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;

final class MakeTest extends AbstractMaker
{
    public static function getCommandName(): string
    {
        return 'make:api:test';
    }

    public static function getCommandDescription(): string
    {
        return 'Generates a Test class.';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->addArgument('name', InputArgument::REQUIRED, 'Class name for your test');
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $class = $generator->createClassNameDetails(
            $input->getArgument('name'),
            'Tests\\Controller\\',
            'Test'
        );

        $generator->generateClass(
            $class->getFullName(),
            __DIR__ . '/../Resources/skeleton/Test.tpl.php',
            [
                'name_lowercase' => \strtolower($input->getArgument('name'))
            ]
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text([
            'Customize the newly created test.',
        ]);
    }
}
