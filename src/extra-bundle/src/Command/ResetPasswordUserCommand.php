<?php

namespace Baldeweg\Bundle\ExtraBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ResetPasswordUserCommand extends Command
{
    protected static $defaultName = 'user:reset-password';
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $encoder,
        private readonly ParameterBagInterface $params
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Resets the password of a user.')
            ->setHelp('This command resets the password of a user.')
            ->addArgument('id', InputArgument::REQUIRED, 'The id of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $user = $this->em->getRepository(
            $this->params->get('baldeweg_extra.userclass')
        )->find(
            $input->getArgument('id')
        );
        $pass = bin2hex(random_bytes(6));
        $user->setPassword(
            $this->encoder->hashPassword($user, $pass)
        );
        $this->em->flush();

        $io->success('Passwort: ' . $pass);

        return Command::SUCCESS;
    }
}
