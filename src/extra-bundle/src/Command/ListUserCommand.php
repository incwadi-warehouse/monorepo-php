<?php

namespace Baldeweg\Bundle\ExtraBundle\Command;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use App\Entity\User;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'user:list')]
class ListUserCommand extends Command
{
    public function __construct(private readonly EntityManagerInterface $em, private readonly ParameterBagInterface $params)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Find and show all users')
            ->setHelp('This command finds and shows all users.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $users = $this->em->getRepository(User::class)->findAll();
        $data = [];
        foreach ($users as $user) {
            $data[] = [
                $user->getId(),
                $user->getUsername(),
                implode(', ', $user->getRoles()),
            ];
        }

        $io->table(
            ['Id', 'User', 'Roles'],
            $data
        );

        return Command::SUCCESS;
    }
}
