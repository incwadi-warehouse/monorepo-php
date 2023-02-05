<?php

namespace Baldeweg\Bundle\ExtraBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Entity\User;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'user:delete')]
class DeleteUserCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly ParameterBagInterface $params)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Deletes a user')
            ->setHelp('This command deletes a user.')
            ->addArgument('id', InputArgument::REQUIRED, 'The id of the user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->em->remove(
            $this->em->getRepository(User::class)->find($input->getArgument('id'))
        );
        $this->em->flush();

        $io->success('The user was deleted!');

        return Command::SUCCESS;
    }
}
