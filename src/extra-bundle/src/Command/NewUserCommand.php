<?php

namespace Baldeweg\Bundle\ExtraBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class NewUserCommand extends Command
{
    protected static $defaultName = 'user:new';
    
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $encoder,
        private readonly ParameterBagInterface $params
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Creates a new user.')
            ->setHelp('This command creates a new user.')
            ->addArgument('name', InputArgument::REQUIRED, 'The name of the user')
            ->addArgument('role', InputArgument::OPTIONAL, 'The role of the user')
            ->addArgument('password', InputArgument::OPTIONAL, 'The password of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $name = $input->getArgument('name');
        $pass = $input->getArgument('password') ?: bin2hex(random_bytes(6));

        $userclass = $this->params->get('baldeweg_extra.userclass');
        $user = new $userclass();
        $user->setUsername($name);
        $user->setPassword(
            $this->encoder->hashPassword($user, $pass)
        );
        $user->setRoles([
            $input->getArgument('role') ?: 'ROLE_USER',
        ]);

        $this->em->persist($user);
        $this->em->flush();

        $io->listing([
            'Username: ' . $user->getUsername(),
            'Password: ' . $pass,
        ]);

        return Command::SUCCESS;
    }
}
