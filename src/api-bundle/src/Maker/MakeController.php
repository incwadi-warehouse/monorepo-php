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

final class MakeController extends AbstractMaker
{
    public static function getCommandName(): string
    {
        return 'make:api:controller';
    }

    public static function getCommandDescription(): string
    {
        return 'Generates a Controller class.';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->addArgument('name', InputArgument::REQUIRED, 'Class name for your controller');
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $class = $generator->createClassNameDetails(
            $input->getArgument('name'),
            'Controller\\',
            'Controller'
        );

        $generator->generateClass(
            $class->getFullName(),
            __DIR__ . '/../Resources/skeleton/Controller.tpl.php',
            [
                'entity' => \ucfirst($input->getArgument('name')),
                'name_lowercase' => \strtolower($input->getArgument('name'))
            ]
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text([
            'Customize the newly created controller.',
        ]);
    }
}
