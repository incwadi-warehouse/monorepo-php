<?php

namespace Baldeweg\Bundle\ExtraBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ShowUserCommand extends Command
{
    protected static $defaultName = 'user:show';
    public function __construct(private readonly EntityManagerInterface $em, private readonly ParameterBagInterface $params)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Shows a user')
            ->setHelp('This command shows a user.')
            ->addArgument('user', InputArgument::REQUIRED, 'The name of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = $this->em->getRepository(
            $this->params->get('baldeweg_extra.userclass')
        )->find(
            $input->getArgument('user')
        );
        $io->listing([
            'Id: ' . $user->getId(),
            'Username: ' . $user->getUsername(),
            'Roles: ' . implode(', ', $user->getRoles()),
        ]);

        return Command::SUCCESS;
    }
}
