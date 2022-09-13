<?php

namespace Baldeweg\Bundle\ExtraBundle\Maker;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\DependencyBuilder;
use Symfony\Bundle\MakerBundle\Generator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;

final class MakeSubscriber extends AbstractMaker
{
    public static function getCommandName(): string
    {
        return 'make:extra:subscriber';
    }

    public static function getCommandDescription(): string
    {
        return 'Generates a Doctrine Event Subscriber class.';
    }

    public function configureCommand(Command $command, InputConfiguration $inputConfig): void
    {
        $command
            ->addArgument('name', InputArgument::REQUIRED, 'Class name for your event subscriber');
    }

    public function configureDependencies(DependencyBuilder $dependencies): void
    {
    }

    public function generate(InputInterface $input, ConsoleStyle $io, Generator $generator): void
    {
        $class = $generator->createClassNameDetails(
            $input->getArgument('name'),
            'EventSubscriber\\',
            'Subscriber'
        );

        $generator->generateClass(
            $class->getFullName(),
            __DIR__ . '/../Resources/skeleton/DoctrineSubscriber.tpl.php',
            []
        );

        $generator->writeChanges();

        $this->writeSuccessMessage($io);

        $io->text([
            'Customize the newly created subscriber.',
            '<fg=yellow>https://www.doctrine-project.org/projects/doctrine-orm/en/2.8/reference/events.html#implementing-event-listeners</>',
            '<fg=yellow>https://symfony.com/doc/current/doctrine/events.html#doctrine-lifecycle-subscribers</>',
        ]);
    }
}
